<?php
namespace frontend\controllers;

use frontend\models\StaticContent;
use frontend\models\StaticType;
use Yii;
use frontend\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\User;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    // TODO: Create controller for Static content
    // TODO: Add rules for static content types based on slug
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @param $typeSlug string StaticType -> name field
     * @param $titleSlug string StaticContent -> slug field
     * @return mixed
     * @throws NotFoundHttpException When no such page found
     */
    public function actionPage($typeSlug, $titleSlug)
    {
        $page = StaticContent::find()
            ->joinWith('type')
            ->andWhere([
                StaticContent::tableName() . '.slug' => $titleSlug,
                StaticType::tableName() . '.slug' => $typeSlug,
                StaticType::tableName() . '.type' => StaticType::TYPE_PAGE,
                StaticType::tableName() . '.status' => StaticType::STATUS_ACTIVE,
            ])
            ->active()
            ->one();
        if (!$page) {
            throw new NotFoundHttpException();
        }
        
        return $this->render('page', ['model' => $page]);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $mainCTABlock = StaticContent::findOneByTypeId(StaticType::ID_MAINCTA_BLOCK);
        $secondaryCTABlock = StaticContent::findOneByTypeId(StaticType::ID_SECONDARYCTA_BLOCK);
        $homeBlocks = StaticContent::findAllByTypeId(StaticType::ID_HOME_BLOCK);
        return $this->render(
            'index',
            [
                'mainCTABlock' => $mainCTABlock,
                'secondaryCTABlock' => $secondaryCTABlock,
                'homeBlocks' => $homeBlocks,
            ]
        );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->addFlash('success', Yii::t('frontend', 'Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->addFlash('error', Yii::t('frontend', 'There was an error sending email.'));
            }

            return $this->refresh();
        }

        $contactUsBlocks = StaticContent::findAllByTypeId(StaticType::ID_CONTACTUS_BLOCK);
        
        return $this->render('contact', [
            'model' => $model,
            'contactUsBlocks' => $contactUsBlocks,
        ]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                Yii::$app->session->addFlash(
                    'success',
                    Yii::t(
                        'auth',
                        'You have successfully registered. Please follow the verification link sent to your email address. {0}',
                        [
                            Html::a(Yii::t('auth', 'Resend?'), ['resend-verification', 'id' => $user->id]),
                        ]
                    )
                );
                return $this->goHome();
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->addFlash('success', Yii::t('frontend', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->addFlash('error', Yii::t('frontend', 'Sorry, we are unable to send reset password email. Please contact site administrator for more details.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     */
    public function actionResetPassword($token)
    {
        $model = new ResetPasswordForm(['token' => $token]);


        if (!$model->validate(['token'])) {
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'authorization',
                    'Wrong password reset token provided. {0}',
                    [
                        Html::a(Yii::t('authorization', 'Resend?'), ['site/request-password-reset']),
                    ]
                )
            );
            return $this->goHome();
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->addFlash('success', Yii::t('frontend', 'New password was saved. You can login now.'));

            return $this->redirect(['login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Resend verification email
     *
     * @param $id string User ID
     * @return \yii\web\Response
     */
    public function actionResendVerification($id)
    {
        $user = User::findOne($id);
        if (!$user || $user->status != User::STATUS_PENDING) {
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'auth',
                    'No such user found. Please make sure you have provided correct credentials and your account is not verified yet.'
                )
            );
            return $this->redirect(['login']);
        }

        if ($user->sendVerificationEmail()) {
            Yii::$app->session->addFlash(
                'success',
                Yii::t(
                    'auth',
                    'Verification link was successfully sent to your email address. Please follow that link to proceed.'
                )
            );
        } else {
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'auth',
                    'Failed to send verification link. Please contact site administrator for more details.'
                )
            );
        }
        return $this->redirect(['index']);
    }

    /**
     * Verify email by one-time token
     *
     * @param $token string
     * @return \yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        $user = User::findByVerificationToken($token, User::STATUS_PENDING);
        
        if (!$user) {
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'auth',
                    'The verification token you have provided is invalid.'
                )
            );
            return $this->goHome();
        }
        
        if (!$user->activate()) {
            Yii::error('Failed to verify user with ID #' . $user->id . ' User errors: ' . json_encode($user->getErrors()), 'auth');
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'auth',
                    'An error occurred during email verification. Please contact site administrator for more details.'
                )
            );
            return $this->redirect(['index']);
        }
        
        if (!Yii::$app->user->login($user)) {
            Yii::error('Failed to login user with ID #' . $user->id,'auth');
            Yii::$app->session->addFlash(
                'error',
                Yii::t(
                    'auth',
                    'An error occurred during automatic login. Please try to login manually.'
                )
            );
            return $this->redirect(['auth']);
        }
        
        Yii::$app->session->addFlash(
            'success',
            Yii::t(
                'auth',
                'You have successfully verified your email address.'
            )
        );
        return $this->goHome();
    }
}

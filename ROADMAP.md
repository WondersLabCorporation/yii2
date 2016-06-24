 # ROADMAP
 
 **Base configuration changes**
 
 - [x] UrlManager
 - [x] AccessRule - override class to include simple role-based access
 - [x] ActiveRecord - add statuses constants
 - [x] Override ActiveQuery for Active record to include -> active() method
 - [x] .htaccess rewrite rules for backend/frontend access. Change request baseUrl config
 - [x] default Mage config
 - [ ] Functional testing for AccessRules
 - [ ] Git tags and composer package for current repo
 - [ ] Tags for releases
 - [x] Verify email feature (as a separate module for example)
 - [ ] User profile form with change password via verification feature (option to disable this feature) 
 - [ ] User profile form with change email via verification to old and new address feature (option to disable fully or partial)
 - [ ] Unit testing of the user model features
 - [ ] HTML5 features for inputs. Like role='tel'
 - [ ] Sitemap generation (if needed)
 - [x] Gii updates for backend controller to include new AccessRule and/or use overrode BackendController
 - [ ] Default migration controller changes to generate new migrations based on overrode Migration class 
 - [ ] Email templates module with token-replacements. This widget can be used as base [Text-area-tokens](https://github.com/mmedojevicbg/yii2-text-area-tokens)
 - [ ] Update gii to include many-to-many and many-to-one relations editing. Use this article as the starting point - [Relations-editing](http://www.yiiframework.com/wiki/836/how-to-use-listbox-and-checkboxlist/)
 - [x] Adjust Gii to generate wide grid and thick forms and views (col-md-6).
 - [x] Add Toaster flash messages - [Toastr](https://github.com/odai-alali/yii2-toastr)
 - [ ] Mailing for dev config
 - [ ] Create backend controller template with default actions. Implement it as a trait or the same way as rest controller for example. Update Gii for newly create template
 - [ ] Override behaviors in a way to append child behavior() instead of parent replace.
 - [ ] Override Yii class for IDE autocomplete. [Cookbook](https://yii2-cookbook.readthedocs.org/ide-autocompletion/)
 - [x] Add google re-captcha and use it as default one if appropriate
 - [ ] Separate admin and user sessions to reduce the number of 400 errors during manual testing and for users with both roles (like web site owner for example)
 - [ ] Create frontendUrlManager in a separate file to include it in backend and frontend. Change Backend Logo URL to send to frontend instead of backend
 - [ ] Add SoftDelete behavior to the overrode active record since it is a common issue [SoftDeleteBehavior](https://packagist.org/packages/yii2tech/ar-softdelete)
 - [ ] Check if 3rd party admin module can be useful like https://packagist.org/packages/yii2tech/admin
 - [ ] Configure Mailer class to include From address by default
 - [x] AdminLTE theme added for backend https://github.com/dmstr/yii2-adminlte-asset

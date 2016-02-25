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
 - [ ] Verify email feature (as a separate module for example)
 - [ ] many-to-many and many-to-one relations management for CRUDs (Gii generator override)
 - [ ] HTML5 features for inputs. Like role='tel'
 - [ ] Sitemap generation (if needed)
 - [ ] Gii updates for backend controller to include new AccessRule
 - [ ] Default migration controller changes to generate new migrations based on overrode Migration class 
 - [ ] Email templates module with token-replacements. This widget can be used as base [Text-area-tokens](https://github.com/mmedojevicbg/yii2-text-area-tokens)
 - [ ] Update gii to include relations editing. Use this article as the starting point - [Relations-editing](http://www.yiiframework.com/wiki/836/how-to-use-listbox-and-checkboxlist/)
 - [x] Add Toaster flash messages - [Toastr](https://github.com/odai-alali/yii2-toastr)
 - [ ] Mailing for dev config
 - [ ] Create backend controller template with default actions. Implement it as a trait or the same way as rest controller for example. Update Gii for newly create template
 - [ ] Override behaviors in a way to append child behavior() instead of parent replace.
 - [ ] Override Yii class for IDE autocomplete. [Cookbook](https://yii2-cookbook.readthedocs.org/ide-autocompletion/)
 - [ ] Add google re-captcha and use it as default one if appropriate
 - [ ] Separate admin and user sessions to reduce the number of 400 errors during manual testing and for users with both roles (like web site owner for example)
 - [ ] Create frontendUrlManager in a separate file to include it in backend and frontend. Change Backend Logo URL to send to frontend instead of backend
 - [ ] Add SoftDelete behavior to the overrode active record since it is a common issue [SoftDeleteBehavior](https://packagist.org/packages/yii2tech/ar-softdelete)
 - [ ] Check if 3rd party admin module can be useful like https://packagist.org/packages/yii2tech/admin

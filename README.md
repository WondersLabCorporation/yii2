Wonderslab Yii 2 Advanced Project Template
==========================================

**Wonderslab** Yii 2 Advanced Project Template is based on *Yii 2 Advanced Project Template* [Yii 2](http://www.yiiframework.com/)

# Changes and additions
_____________________

### Common
* **AccessRule** - class override to include simple role-based access to actions
* **.htaccess** - mod_rewrite rules to send all /backend requests to backend application,
  slicing requests to slicing folder and / requests to frontend application
* **ActiveRecord** - class override to include status constants active/deleted and methods for human-readable titles
* **ActiveRecordQuery** - ActiveQuery for ActiveRecord class with active() method and overrode findAll(...) to include condition
* **User** - model override to include Admin/User roles. 
Console and Backend User models added to allow both roles. Frontend User model allows User role only
* **configs** - index files re-writed in a way to include dev.php config files as the last stage. 
At the same time those files are in gitignore so any local configs can be placed there. common/config/sample.dev.php file added
* **Mage config** - default Magellan config added for development and staging environment [More details](http://magephp.com/#config-environment)

### Backend
* **BaseController** - includes role-based Access rule and base behaviors

### Console
* **Migration** - class override to include table options. MySQL-related options implemented only for now.


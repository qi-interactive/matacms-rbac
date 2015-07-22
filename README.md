MATA CMS rbac
==========================================

![MATA CMS Module](https://s3-eu-west-1.amazonaws.com/qi-interactive/assets/mata-cms/gear-mata-logo%402x.png)

MATA CMS rbac provides a web interface for advanced access control


Acknowledgement
------------
This module is based on the excellent [Yii2-rbacr by dektrium](https://github.com/dektrium/yii2-rbac).

Installation
------------

- Add the module using composer:

```json
"matacms/matacms-rbac": "~1.0.0"
```

-  Run migrations
```
php yii migrate/up --migrationPath=@vendor/matacms/matacms-rbac/migrations
```

Changelog
---------

## 1.0.2-alpha, July 22, 2015

- Added migration with initial roles for MATA CMS, Assignment widget updated, Bootstrap saves assignment roles

## 1.0.1-alpha, July 22, 2015

- Updates

## 1.0.0-alpha, July 20, 2015

- Initial release

### Actions
* [after_create_article](#after_create_article)
* [after_create_challenge](#after_create_challenge)
* [after_create_challenge_attempt](#after_create_challenge_attempt)
* [after_create_class](#after_create_class)
* [after_create_class_challenge](#after_create_class_challenge)
* [after_create_user](#after_create_user)
* [after_create_user_has_challenge_token](#after_create_user_has_challenge_token)
* [after_delete_article](#after_delete_article)
* [after_delete_challenge](#after_delete_challenge)
* [after_delete_challenge_attempt](#after_delete_challenge_attempt)
* [after_delete_class](#after_delete_class)
* [after_delete_class_challenge](#after_delete_class_challenge)
* [after_delete_class_membership](#after_delete_class_membership)
* [after_delete_user](#after_delete_user)
* [after_read_article](#after_read_article)
* [after_read_challenge](#after_read_challenge)
* [after_read_challenge_attempt](#after_read_challenge_attempt)
* [after_read_class](#after_read_class)
* [after_read_class_challenge](#after_read_class_challenge)
* [after_read_class_membership](#after_read_class_membership)
* [after_read_user](#after_read_user)
* [after_read_user_challenge](#after_read_user_challenge)
* [after_read_user_has_challenge_token](#after_read_user_has_challenge_token)
* [after_update_article](#after_update_article)
* [after_update_challenge](#after_update_challenge)
* [after_update_class](#after_update_class)
* [after_update_class_challenge](#after_update_class_challenge)
* [after_update_user](#after_update_user)
* [after_update_user_has_challenge_token](#after_update_user_has_challenge_token)
* [before_create_article](#before_create_article)
* [before_create_challenge](#before_create_challenge)
* [before_create_challenge_attempt](#before_create_challenge_attempt)
* [before_create_class](#before_create_class)
* [before_create_class_challenge](#before_create_class_challenge)
* [before_create_user](#before_create_user)
* [before_create_user_has_challenge_token](#before_create_user_has_challenge_token)
* [before_delete_article](#before_delete_article)
* [before_delete_challenge](#before_delete_challenge)
* [before_delete_challenge_attempt](#before_delete_challenge_attempt)
* [before_delete_class](#before_delete_class)
* [before_delete_class_challenge](#before_delete_class_challenge)
* [before_delete_class_membership](#before_delete_class_membership)
* [before_delete_user](#before_delete_user)
* [before_read_article](#before_read_article)
* [before_read_challenge](#before_read_challenge)
* [before_read_challenge_attempt](#before_read_challenge_attempt)
* [before_read_class](#before_read_class)
* [before_read_class_challenge](#before_read_class_challenge)
* [before_read_class_membership](#before_read_class_membership)
* [before_read_user](#before_read_user)
* [before_read_user_challenge](#before_read_user_challenge)
* [before_read_user_has_challenge_token](#before_read_user_has_challenge_token)
* [before_update_article](#before_update_article)
* [before_update_challenge](#before_update_challenge)
* [before_update_class](#before_update_class)
* [before_update_class_challenge](#before_update_class_challenge)
* [before_update_user](#before_update_user)
* [before_update_user_has_challenge_token](#before_update_user_has_challenge_token)
* [disable_plugin](#disable_plugin)
* [disable_user_theme](#disable_user_theme)
* [enable_plugin](#enable_plugin)
* [enable_user_theme](#enable_user_theme)
* [generate_view](#generate_view)
* [show_add_article](#show_add_article)
* [show_add_challenge](#show_add_challenge)
* [show_add_class](#show_add_class)
* [show_add_user](#show_add_user)
* [show_admin_login](#show_admin_login)
* [show_article_manager](#show_article_manager)
* [show_challenge_list](#show_challenge_list)
* [show_challenge_manager](#show_challenge_manager)
* [show_class_challenges](#show_class_challenges)
* [show_class_manager](#show_class_manager)
* [show_class_memberships](#show_class_memberships)
* [show_dashboard](#show_dashboard)
* [show_edit_article](#show_edit_article)
* [show_edit_challenge](#show_edit_challenge)
* [show_edit_code](#show_edit_code)
* [show_edit_user](#show_edit_user)
* [show_forgot_password](#show_forgot_password)
* [show_landing_page](#show_landing_page)
* [show_login](#show_login)
* [show_main_login](#show_main_login)
* [show_progress_report](#show_progress_report)
* [show_rankings](#show_rankings)
* [show_read_article](#show_read_article)
* [show_register_user](#show_register_user)
* [show_reset_password](#show_reset_password)
* [show_show_challenge](#show_show_challenge)
* [show_show_class](#show_show_class)
* [show_try_challenge](#show_try_challenge)
* [show_user_manager](#show_user_manager)

#### <a name="after_create_article"></a>Action: after_create_article
Called when an article has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_article', '[plugin]_after_create_article', 10, 1);

function [plugin]_after_create_article([parameters]) {
  // do something
}
```

#### <a name="after_create_challenge"></a>Action: after_create_challenge
Called when a challenge has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_challenge', '[plugin]_after_create_challenge', 10, 1);

function [plugin]_after_create_challenge([parameters]) {
  // do something
}
```

#### <a name="after_create_challenge_attempt"></a>Action: after_create_challenge_attempt
Called when a challenge attempt has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_challenge_attempt', '[plugin]_after_create_challenge_attempt', 10, 1);

function [plugin]_after_create_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="after_create_class"></a>Action: after_create_class
Called when a class has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_class', '[plugin]_after_create_class', 10, 1);

function [plugin]_after_create_class([parameters]) {
  // do something
}
```

#### <a name="after_create_class_challenge"></a>Action: after_create_class_challenge
Called when a class challenge has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_class_challenge', '[plugin]_after_create_class_challenge', 10, 1);

function [plugin]_after_create_class_challenge([parameters]) {
  // do something
}
```

#### <a name="after_create_user"></a>Action: after_create_user
Called when a user has been inserted into the database.

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_user', '[plugin]_after_create_user', 10, 1);

function [plugin]_after_create_user([parameters]) {
  // do something
}
```

#### <a name="after_create_user_has_challenge_token"></a>Action: after_create_user_has_challenge_token
Called when a "user has challenge token"" has been inserted into the database."

##### Parameters
```php
$id the id of the new row,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_create_user_has_challenge_token', '[plugin]_after_create_user_has_challenge_token', 10, 1);

function [plugin]_after_create_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="after_delete_article"></a>Action: after_delete_article
Called when an article has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_article', '[plugin]_after_delete_article', 10, 1);

function [plugin]_after_delete_article([parameters]) {
  // do something
}
```

#### <a name="after_delete_challenge"></a>Action: after_delete_challenge
Called when a challenge has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_challenge', '[plugin]_after_delete_challenge', 10, 1);

function [plugin]_after_delete_challenge([parameters]) {
  // do something
}
```

#### <a name="after_delete_challenge_attempt"></a>Action: after_delete_challenge_attempt
Called when a challenge attempt has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_challenge_attempt', '[plugin]_after_delete_challenge_attempt', 10, 1);

function [plugin]_after_delete_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="after_delete_class"></a>Action: after_delete_class
Called when a class has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_class', '[plugin]_after_delete_class', 10, 1);

function [plugin]_after_delete_class([parameters]) {
  // do something
}
```

#### <a name="after_delete_class_challenge"></a>Action: after_delete_class_challenge
Called when a class challenge has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_class_challenge', '[plugin]_after_delete_class_challenge', 10, 1);

function [plugin]_after_delete_class_challenge([parameters]) {
  // do something
}
```

#### <a name="after_delete_class_membership"></a>Action: after_delete_class_membership
Called when a class membership has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_class_membership', '[plugin]_after_delete_class_membership', 10, 1);

function [plugin]_after_delete_class_membership([parameters]) {
  // do something
}
```

#### <a name="after_delete_user"></a>Action: after_delete_user
Called when a user has been deleted from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_delete_user', '[plugin]_after_delete_user', 10, 1);

function [plugin]_after_delete_user([parameters]) {
  // do something
}
```

#### <a name="after_read_article"></a>Action: after_read_article
Called when a article has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_article', '[plugin]_after_read_article', 10, 1);

function [plugin]_after_read_article([parameters]) {
  // do something
}
```

#### <a name="after_read_challenge"></a>Action: after_read_challenge
Called when a challenge has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_challenge', '[plugin]_after_read_challenge', 10, 1);

function [plugin]_after_read_challenge([parameters]) {
  // do something
}
```

#### <a name="after_read_challenge_attempt"></a>Action: after_read_challenge_attempt
Called when a challenge attempt has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_challenge_attempt', '[plugin]_after_read_challenge_attempt', 10, 1);

function [plugin]_after_read_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="after_read_class"></a>Action: after_read_class
Called when a class has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_class', '[plugin]_after_read_class', 10, 1);

function [plugin]_after_read_class([parameters]) {
  // do something
}
```

#### <a name="after_read_class_challenge"></a>Action: after_read_class_challenge
Called when a class challenge has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_class_challenge', '[plugin]_after_read_class_challenge', 10, 1);

function [plugin]_after_read_class_challenge([parameters]) {
  // do something
}
```

#### <a name="after_read_class_membership"></a>Action: after_read_class_membership
Called when a class membership has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_class_membership', '[plugin]_after_read_class_membership', 10, 1);

function [plugin]_after_read_class_membership([parameters]) {
  // do something
}
```

#### <a name="after_read_user"></a>Action: after_read_user
Called when a user has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_user', '[plugin]_after_read_user', 10, 1);

function [plugin]_after_read_user([parameters]) {
  // do something
}
```

#### <a name="after_read_user_challenge"></a>Action: after_read_user_challenge
Called when a user challenge has been read from the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_user_challenge', '[plugin]_after_read_user_challenge', 10, 1);

function [plugin]_after_read_user_challenge([parameters]) {
  // do something
}
```

#### <a name="after_read_user_has_challenge_token"></a>Action: after_read_user_has_challenge_token
Called when a "user has challenge token"" has been read from the database."

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_read_user_has_challenge_token', '[plugin]_after_read_user_has_challenge_token', 10, 1);

function [plugin]_after_read_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="after_update_article"></a>Action: after_update_article
Called when an article has been updated in the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_article', '[plugin]_after_update_article', 10, 1);

function [plugin]_after_update_article([parameters]) {
  // do something
}
```

#### <a name="after_update_challenge"></a>Action: after_update_challenge
Called when a challenge has been updated in the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_challenge', '[plugin]_after_update_challenge', 10, 1);

function [plugin]_after_update_challenge([parameters]) {
  // do something
}
```

#### <a name="after_update_class"></a>Action: after_update_class
Called when a class has been updated in the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_class', '[plugin]_after_update_class', 10, 1);

function [plugin]_after_update_class([parameters]) {
  // do something
}
```

#### <a name="after_update_class_challenge"></a>Action: after_update_class_challenge
Called when a class challenge has been updated in the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_class_challenge', '[plugin]_after_update_class_challenge', 10, 1);

function [plugin]_after_update_class_challenge([parameters]) {
  // do something
}
```

#### <a name="after_update_user"></a>Action: after_update_user
Called when a user has been updated in the database.

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_user', '[plugin]_after_update_user', 10, 1);

function [plugin]_after_update_user([parameters]) {
  // do something
}
```

#### <a name="after_update_user_has_challenge_token"></a>Action: after_update_user_has_challenge_token
Called when a "user has challenge token"" has been updated in the database."

##### Parameters
```php
$params the params to the query
```

##### Usage
```php
Plugin::add_action('after_update_user_has_challenge_token', '[plugin]_after_update_user_has_challenge_token', 10, 1);

function [plugin]_after_update_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="before_create_article"></a>Action: before_create_article
Called when an article is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_article', '[plugin]_before_create_article', 10, 1);

function [plugin]_before_create_article([parameters]) {
  // do something
}
```

#### <a name="before_create_challenge"></a>Action: before_create_challenge
Called when a challenge is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_challenge', '[plugin]_before_create_challenge', 10, 1);

function [plugin]_before_create_challenge([parameters]) {
  // do something
}
```

#### <a name="before_create_challenge_attempt"></a>Action: before_create_challenge_attempt
Called when a challenge attempt is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_challenge_attempt', '[plugin]_before_create_challenge_attempt', 10, 1);

function [plugin]_before_create_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="before_create_class"></a>Action: before_create_class
Called when a class is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_class', '[plugin]_before_create_class', 10, 1);

function [plugin]_before_create_class([parameters]) {
  // do something
}
```

#### <a name="before_create_class_challenge"></a>Action: before_create_class_challenge
Called when a class challenge is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_class_challenge', '[plugin]_before_create_class_challenge', 10, 1);

function [plugin]_before_create_class_challenge([parameters]) {
  // do something
}
```

#### <a name="before_create_user"></a>Action: before_create_user
Called when a user is about to be inserted into the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_user', '[plugin]_before_create_user', 10, 1);

function [plugin]_before_create_user([parameters]) {
  // do something
}
```

#### <a name="before_create_user_has_challenge_token"></a>Action: before_create_user_has_challenge_token
Called when a "user has challenge token"" is about to be inserted into the database."

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_create_user_has_challenge_token', '[plugin]_before_create_user_has_challenge_token', 10, 1);

function [plugin]_before_create_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="before_delete_article"></a>Action: before_delete_article
Called when an article is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_article', '[plugin]_before_delete_article', 10, 1);

function [plugin]_before_delete_article([parameters]) {
  // do something
}
```

#### <a name="before_delete_challenge"></a>Action: before_delete_challenge
Called when a challenge is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_challenge', '[plugin]_before_delete_challenge', 10, 1);

function [plugin]_before_delete_challenge([parameters]) {
  // do something
}
```

#### <a name="before_delete_challenge_attempt"></a>Action: before_delete_challenge_attempt
Called when a challenge attempt is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_challenge_attempt', '[plugin]_before_delete_challenge_attempt', 10, 1);

function [plugin]_before_delete_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="before_delete_class"></a>Action: before_delete_class
Called when a class is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_class', '[plugin]_before_delete_class', 10, 1);

function [plugin]_before_delete_class([parameters]) {
  // do something
}
```

#### <a name="before_delete_class_challenge"></a>Action: before_delete_class_challenge
Called when a class challenge is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_class_challenge', '[plugin]_before_delete_class_challenge', 10, 1);

function [plugin]_before_delete_class_challenge([parameters]) {
  // do something
}
```

#### <a name="before_delete_class_membership"></a>Action: before_delete_class_membership
Called when a class membership is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_class_membership', '[plugin]_before_delete_class_membership', 10, 1);

function [plugin]_before_delete_class_membership([parameters]) {
  // do something
}
```

#### <a name="before_delete_user"></a>Action: before_delete_user
Called when a user is about to be deleted from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_delete_user', '[plugin]_before_delete_user', 10, 1);

function [plugin]_before_delete_user([parameters]) {
  // do something
}
```

#### <a name="before_read_article"></a>Action: before_read_article
Called when a article is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_article', '[plugin]_before_read_article', 10, 1);

function [plugin]_before_read_article([parameters]) {
  // do something
}
```

#### <a name="before_read_challenge"></a>Action: before_read_challenge
Called when a challenge is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_challenge', '[plugin]_before_read_challenge', 10, 1);

function [plugin]_before_read_challenge([parameters]) {
  // do something
}
```

#### <a name="before_read_challenge_attempt"></a>Action: before_read_challenge_attempt
Called when a challenge attempt is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_challenge_attempt', '[plugin]_before_read_challenge_attempt', 10, 1);

function [plugin]_before_read_challenge_attempt([parameters]) {
  // do something
}
```

#### <a name="before_read_class"></a>Action: before_read_class
Called when a class is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_class', '[plugin]_before_read_class', 10, 1);

function [plugin]_before_read_class([parameters]) {
  // do something
}
```

#### <a name="before_read_class_challenge"></a>Action: before_read_class_challenge
Called when a class challenge is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_class_challenge', '[plugin]_before_read_class_challenge', 10, 1);

function [plugin]_before_read_class_challenge([parameters]) {
  // do something
}
```

#### <a name="before_read_class_membership"></a>Action: before_read_class_membership
Called when a class membership is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_class_membership', '[plugin]_before_read_class_membership', 10, 1);

function [plugin]_before_read_class_membership([parameters]) {
  // do something
}
```

#### <a name="before_read_user"></a>Action: before_read_user
Called when a user is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_user', '[plugin]_before_read_user', 10, 1);

function [plugin]_before_read_user([parameters]) {
  // do something
}
```

#### <a name="before_read_user_challenge"></a>Action: before_read_user_challenge
Called when a user challenge is about to be read from the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_user_challenge', '[plugin]_before_read_user_challenge', 10, 1);

function [plugin]_before_read_user_challenge([parameters]) {
  // do something
}
```

#### <a name="before_read_user_has_challenge_token"></a>Action: before_read_user_has_challenge_token
Called when a "user has challenge token"" is about to be read from the database."

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_read_user_has_challenge_token', '[plugin]_before_read_user_has_challenge_token', 10, 1);

function [plugin]_before_read_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="before_update_article"></a>Action: before_update_article
Called when an article is about to be updated in the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_article', '[plugin]_before_update_article', 10, 1);

function [plugin]_before_update_article([parameters]) {
  // do something
}
```

#### <a name="before_update_challenge"></a>Action: before_update_challenge
Called when a challenge is about to be updated in the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_challenge', '[plugin]_before_update_challenge', 10, 1);

function [plugin]_before_update_challenge([parameters]) {
  // do something
}
```

#### <a name="before_update_class"></a>Action: before_update_class
Called when a class is about to be updated in the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_class', '[plugin]_before_update_class', 10, 1);

function [plugin]_before_update_class([parameters]) {
  // do something
}
```

#### <a name="before_update_class_challenge"></a>Action: before_update_class_challenge
Called when a class challenge is about to be updated in the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_class_challenge', '[plugin]_before_update_class_challenge', 10, 1);

function [plugin]_before_update_class_challenge([parameters]) {
  // do something
}
```

#### <a name="before_update_user"></a>Action: before_update_user
Called when a user is about to be updated in the database.

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_user', '[plugin]_before_update_user', 10, 1);

function [plugin]_before_update_user([parameters]) {
  // do something
}
```

#### <a name="before_update_user_has_challenge_token"></a>Action: before_update_user_has_challenge_token
Called when a "user has challenge token"" is about to be updated in the database."

##### Parameters
```php
$sql the base sql query,
$params the params to the query
```

##### Usage
```php
Plugin::add_action('before_update_user_has_challenge_token', '[plugin]_before_update_user_has_challenge_token', 10, 1);

function [plugin]_before_update_user_has_challenge_token([parameters]) {
  // do something
}
```

#### <a name="disable_plugin"></a>Action: disable_plugin
Called for each plugin that is disabled

##### Parameters
```php
$plugin the name and path to the plugin file
```

##### Usage
```php
Plugin::add_action('disable_plugin', '[plugin]_disable_plugin', 10, 1);

function [plugin]_disable_plugin([parameters]) {
  // do something
}
```

#### <a name="disable_user_theme"></a>Action: disable_user_theme
Called when a user theme has been disabled

##### Parameters
```php
$theme the name and path of the theme
```

##### Usage
```php
Plugin::add_action('disable_user_theme', '[plugin]_disable_user_theme', 10, 1);

function [plugin]_disable_user_theme([parameters]) {
  // do something
}
```

#### <a name="enable_plugin"></a>Action: enable_plugin
Called for each plugin that is enabled

##### Parameters
```php
$plugin the name and path to the plugin file
```

##### Usage
```php
Plugin::add_action('enable_plugin', '[plugin]_enable_plugin', 10, 1);

function [plugin]_enable_plugin([parameters]) {
  // do something
}
```

#### <a name="enable_user_theme"></a>Action: enable_user_theme
Called when a user theme has been enabled

##### Parameters
```php
$theme the name and path of the theme
```

##### Usage
```php
Plugin::add_action('enable_user_theme', '[plugin]_enable_user_theme', 10, 1);

function [plugin]_enable_user_theme([parameters]) {
  // do something
}
```

#### <a name="generate_view"></a>Action: generate_view
Called when a page is about to be passed to Smarty for presentation.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('generate_view', '[plugin]_generate_view', 10, 1);

function [plugin]_generate_view([parameters]) {
  // do something
}
```

#### <a name="show_add_article"></a>Action: show_add_article
Called when the add article page is about to be displayed

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_add_article', '[plugin]_show_add_article', 10, 1);

function [plugin]_show_add_article([parameters]) {
  // do something
}
```

#### <a name="show_add_challenge"></a>Action: show_add_challenge
Called when the add challenge page is about to be displayed

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_add_challenge', '[plugin]_show_add_challenge', 10, 1);

function [plugin]_show_add_challenge([parameters]) {
  // do something
}
```

#### <a name="show_add_class"></a>Action: show_add_class
Called when the add class page is about to be displayed

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_add_class', '[plugin]_show_add_class', 10, 1);

function [plugin]_show_add_class([parameters]) {
  // do something
}
```

#### <a name="show_add_user"></a>Action: show_add_user
Called when the add user page is about to be displayed

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_add_user', '[plugin]_show_add_user', 10, 1);

function [plugin]_show_add_user([parameters]) {
  // do something
}
```

#### <a name="show_admin_login"></a>Action: show_admin_login
Called when the admin login page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_admin_login', '[plugin]_show_admin_login', 10, 1);

function [plugin]_show_admin_login([parameters]) {
  // do something
}
```

#### <a name="show_article_manager"></a>Action: show_article_manager
Called when the article manager is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_article_manager', '[plugin]_show_article_manager', 10, 1);

function [plugin]_show_article_manager([parameters]) {
  // do something
}
```

#### <a name="show_challenge_list"></a>Action: show_challenge_list
Called when the challenge list is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_challenge_list', '[plugin]_show_challenge_list', 10, 1);

function [plugin]_show_challenge_list([parameters]) {
  // do something
}
```

#### <a name="show_challenge_manager"></a>Action: show_challenge_manager
Called when the challenge manager is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_challenge_manager', '[plugin]_show_challenge_manager', 10, 1);

function [plugin]_show_challenge_manager([parameters]) {
  // do something
}
```

#### <a name="show_class_challenges"></a>Action: show_class_challenges
Called when the class challenges is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_class_challenges', '[plugin]_show_class_challenges', 10, 1);

function [plugin]_show_class_challenges([parameters]) {
  // do something
}
```

#### <a name="show_class_manager"></a>Action: show_class_manager
Called when the class manager is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_class_manager', '[plugin]_show_class_manager', 10, 1);

function [plugin]_show_class_manager([parameters]) {
  // do something
}
```

#### <a name="show_class_memberships"></a>Action: show_class_memberships
Called when the class memberships is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_class_memberships', '[plugin]_show_class_memberships', 10, 1);

function [plugin]_show_class_memberships([parameters]) {
  // do something
}
```

#### <a name="show_dashboard"></a>Action: show_dashboard
Called when the dashboard is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_dashboard', '[plugin]_show_dashboard', 10, 1);

function [plugin]_show_dashboard([parameters]) {
  // do something
}
```

#### <a name="show_edit_article"></a>Action: show_edit_article
Called when the edit article page is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_edit_article', '[plugin]_show_edit_article', 10, 1);

function [plugin]_show_edit_article([parameters]) {
  // do something
}
```

#### <a name="show_edit_challenge"></a>Action: show_edit_challenge
Called when the edit challenge page is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_edit_challenge', '[plugin]_show_edit_challenge', 10, 1);

function [plugin]_show_edit_challenge([parameters]) {
  // do something
}
```

#### <a name="show_edit_code"></a>Action: show_edit_code
Called when the edit code page is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_edit_code', '[plugin]_show_edit_code', 10, 1);

function [plugin]_show_edit_code([parameters]) {
  // do something
}
```

#### <a name="show_edit_user"></a>Action: show_edit_user
Called when the edit user page is about to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_edit_user', '[plugin]_show_edit_user', 10, 1);

function [plugin]_show_edit_user([parameters]) {
  // do something
}
```

#### <a name="show_forgot_password"></a>Action: show_forgot_password
Called when the forgot password page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_forgot_password', '[plugin]_show_forgot_password', 10, 1);

function [plugin]_show_forgot_password([parameters]) {
  // do something
}
```

#### <a name="show_landing_page"></a>Action: show_landing_page
Called when the landing page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_landing_page', '[plugin]_show_landing_page', 10, 1);

function [plugin]_show_landing_page([parameters]) {
  // do something
}
```

#### <a name="show_login"></a>Action: show_login
Called when the login page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_login', '[plugin]_show_login', 10, 1);

function [plugin]_show_login([parameters]) {
  // do something
}
```

#### <a name="show_main_login"></a>Action: show_main_login
Called when the main login page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_main_login', '[plugin]_show_main_login', 10, 1);

function [plugin]_show_main_login([parameters]) {
  // do something
}
```

#### <a name="show_progress_report"></a>Action: show_progress_report
Called when the progress report page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_progress_report', '[plugin]_show_progress_report', 10, 1);

function [plugin]_show_progress_report([parameters]) {
  // do something
}
```

#### <a name="show_rankings"></a>Action: show_rankings
Called when the rankings page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_rankings', '[plugin]_show_rankings', 10, 1);

function [plugin]_show_rankings([parameters]) {
  // do something
}
```

#### <a name="show_read_article"></a>Action: show_read_article
Called when an article page is to be displayed.


##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_read_article', '[plugin]_show_read_article', 10, 1);

function [plugin]_show_read_article([parameters]) {
  // do something
}
```

#### <a name="show_register_user"></a>Action: show_register_user
Called when the register user page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_register_user', '[plugin]_show_register_user', 10, 1);

function [plugin]_show_register_user([parameters]) {
  // do something
}
```

#### <a name="show_reset_password"></a>Action: show_reset_password
Called when the reset password page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_reset_password', '[plugin]_show_reset_password', 10, 1);

function [plugin]_show_reset_password([parameters]) {
  // do something
}
```

#### <a name="show_show_challenge"></a>Action: show_show_challenge
Called when the show challenge page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_show_challenge', '[plugin]_show_show_challenge', 10, 1);

function [plugin]_show_show_challenge([parameters]) {
  // do something
}
```

#### <a name="show_show_class"></a>Action: show_show_class
Called when the show class page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_show_class', '[plugin]_show_show_class', 10, 1);

function [plugin]_show_show_class([parameters]) {
  // do something
}
```

#### <a name="show_try_challenge"></a>Action: show_try_challenge
Called when the try challenge page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_try_challenge', '[plugin]_show_try_challenge', 10, 1);

function [plugin]_show_try_challenge([parameters]) {
  // do something
}
```

#### <a name="show_user_manager"></a>Action: show_user_manager
Called when the user manager page is to be displayed.

##### Parameters
```php
$smarty the smarty object
```

##### Usage
```php
Plugin::add_action('show_user_manager', '[plugin]_show_user_manager', 10, 1);

function [plugin]_show_user_manager([parameters]) {
  // do something
}
```

***

##### Overview

* [Install a plugin or theme](./Plugin-API-Install)
* [Develop a plugin](./Plugin-API-Plugin)
* [Develop a theme](./Plugin-API-Theme)
* [Plugin API Actions](./Plugin-API-Actions)
* [Plugin API Pages and Menus](./Plugin-API-Pages-and-Menus)

1) add missing parameters to config file instead of getting them directly from .env
2) format code to meet psr-2 code standards
3) protected $repository should replaced to private $repository in BookingController as it is used only within that class
4) in BookingController@index() there is no else condition, so we may have cases when we will not have $response defined,
 instead of manually checking this  
 ```php
 if ($request->__authenticatedUser->user_type == env('ADMIN_ROLE_ID') || $request->__authenticatedUser->user_type == env('SUPERADMIN_ROLE_ID');
 ```
 we should use Laravel Policy and it will be good to have isAdmin() helper,
 instead of 
  ```php
 $request->__authenticatedUser we should use auth()->user() or $request->user();
```
 I am not sure that this line is correct:
 ```php
 if($user_id = $request->get('user_id'));
```
 as we may have security issues, as all users can check other users jobs havong just id so I think we should also check if User is authenticated and then only show his jobs

5. BookingController@show() here I would recommend to do Route Binding and then just load() desired relation to the model and again we should check $id if it is belongss to authenticated user which is better to do with Laravel Policy and create custom request class and call that Policy in authorize() method

6. 
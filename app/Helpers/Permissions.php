<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * **************************************************
 * ************** End-User section ****************
 * **************************************************
 */


/**
 *
 * End-User Prmissions
 *
 * TO-DO:sz_note: Need some checks on the fromat of the response, it can be better.
 *
 */
    if (!function_exists('ListPermissions')) {
        function ListPermissions()
        {
            try {
                $all_permissions = [
                    [
                        "group" => "UserController",
                        "permissions" => [
                            ["id" => 1, "name" => "get dashboard information", "route" => "user.dashboard", "method" => "get"],
                            ["id" => 2, "name" => "get user information", "route" => "user.info", "method" => "get"],
                            ["id" => 3, "name" => "update user information", "route" => "user.update.info", "method" => "post"],
                            ["id" => 4, "name" => "upload document", "route" => "user.upload.document", "method" => "post"],
                        ]
                    ],
                    [
                        "group" => "ChangePasswordController",
                        "permissions" => [
                            ["id" => 5, "name" => "change password", "route" => "user.change.password", "method" => "post"],
                            ["id" => 6, "name" => "confirm changing password", "route" => "user.confirm.change.password", "method" => "post"],
                        ]
                    ],
                    [
                        "group" => "PhoneNumberController",
                        "permissions" => [
                            ["id" => 7, "name" => "add phone number", "route" => "user.add.phone", "method" => "post"],
                            ["id" => 8, "name" => "update phone number", "route" => "user.update.phone", "method" => "post"],
                            ["id" => 9, "name" => "delete phone number", "route" => "user.delete.phone", "method" => "get"],
                            ["id" => 10, "name" => "verify phone number", "route" => "user.verify.phone", "method" => "get"],
                            ["id" => 11, "name" => "confirm verifying phone number", "route" => "user.confirm.verify.phone", "method" => "post"],
                        ]
                    ],
                    [
                        "group" => "CreditCardController",
                        "permissions" => [
                            ["id" => 12, "name" => "list credit cards", "route" => "user.list.creditcards", "method" => "get"],
                            ["id" => 13, "name" => "add credit card", "route" => "user.add.creditcard", "method" => "post"],
                            ["id" => 14, "name" => "delete credit card", "route" => "user.delete.creditcard", "method" => "post"],
                        ]
                    ],
                    [
                        "group" => "BankInformationController",
                        "permissions" => [
                            ["id" => 15, "name" => "list bank information", "route" => "user.list.bankinfo", "method" => "get"],
                            ["id" => 16, "name" => "add bank information", "route" => "user.add.bankinfo", "method" => "post"],
                            ["id" => 17, "name" => "delete bank information", "route" => "user.delete.bankinfo", "method" => "post"],
                        ]
                    ],
                    [
                        "group" => "PackageController",
                        "permissions" => [
                            ["id" => 18, "name" => "get package", "route" => "user.get.package", "method" => "get"],
                            ["id" => 19, "name" => "select package", "route" => "user.select.package", "method" => "get"],
                            ["id" => 20, "name" => "buy package", "route" => "user.buy.package", "method" => "get"],
                            ["id" => 21, "name" => "confirm buying package", "route" => "user.confirm.buy.package", "method" => "get"],
                        ]
                    ],
                    [
                        "group" => "PostController",
                        "permissions" => [
                            ["id" => 22, "name" => "create post", "route" => "user.create.post", "method" => "post"],
                            // ["id" => 23, "name" => "read post", "route" => "user.read.post", "method" => "get"],
                            ["id" => 24, "name" => "update post", "route" => "user.update.post", "method" => "post"],
                            ["id" => 25, "name" => "delete post", "route" => "user.delete.post", "method" => "delete"],
                            ["id" => 26, "name" => "renew post", "route" => "user.renew.post", "method" => "post"],
                            ["id" => 27, "name" => "change post publish statment", "route" => "user.change.post.publish.statement", "method" => "get"],
                        ]
                    ],
                    [
                        "group" => "MailController",
                        "permissions" => [
                            ["id" => 28, "name" => "update mail", "route" => "user.update.mail", "method" => "post"],
                            ["id" => 29, "name" => "confirm updating mail", "route" => "user.confirm.update.mail", "method" => "post"],
                            ["id" => 30, "name" => "cancel updating mail", "route" => "user.cancel.update.mail", "method" => "get"],
                        ]
                    ],
                    [
                        "group" => "Others",
                        "permissions" => [
                            ["id" => 101, "name" => "permission name", "route" => "function or view (not route)", "method" => "get"],
                        ]
                    ]
                ];
                return ["status" => true, "data" => collect($all_permissions), "message" => "success", "http" => 200];
            }
            //
            catch (\Exception $e) {
                return ["status" => false, "data" => [], "message" => $e->getMessage(), "http" => 400];
            }
        }
    }

    if (!function_exists('CheckPermission')) {
        function CheckPermission($permission_id)
        {
            try {
                $user = Auth::guard('user-api')->user();
                if ($user->parentId != null && $user->roleId != null) {

                    $permission = ListPermissions()['data']->pluck('permissions')->flatten(1)->where("id", $permission_id)->first();
                    $permissions = collect($user->Role->Permissions);
                    if (!$permissions->where('route', $permission['route'])->first()) {

                        logging_system("user", "error", $user->uuid, "not_set", request()->ip(), "Permissions Helper: User has no permission");

                        return false;
                    }
                }

                return true;
            }
            //
            catch (\Exception $e) {
                return ["status" => false, "data" => [], "message" => $e->getMessage(), "http" => 400];
            }
        }
    }
/** Close End-User Prmissions */

/**
 * **************************************************
 * ************** Admin-User section ****************
 * **************************************************
 */

/** Admin-User Prmissions */
    if (!function_exists('Admin_ListPermissions')) {
        function Admin_ListPermissions()
        {
            $all_permissions = [
                [
                    "group" => "admins_roles_permissions_section",
                    "routes" => ["admin.roles.list.all", "admin.roles.create",
                    "admin.roles.update", "admin.roles.delete", "admin.roles.assign.permissions", "admin.roles.unassign.permissions"]
                ],
                [
                    "group" => "admin_section",
                    "routes" => ["admin.account.page", "admin.change.account.password", "admin.list.admin.users", "admin.create.admin.user", "admin.update.admin.user"
                    , "admin.change.admin.user.status", "admin.reset.admin.user.password", "admin.delete.admin.user","admin.restore.admin.user"]
                ],
                [
                    "group" => "plans_section",
                    "routes" => ["admin.careers.list", "admin.careers.get.plan",
                    "admin.careers.store", "admin.careers.update", "admin.careers.destroy"]
                ],
                [
                    "group" => "packages_section",
                    "routes" => ["admin.packages.create", "admin.packages.list.all",
                    "admin.packages.update", "admin.packages.delete"]
                ],
                [
                    "group" => "categories_section",
                    "routes" => ["admin.categories.list", "admin.categories.store",
                    "admin.categories.update", "admin.categories.destroy", "admin.categories.select.category"]
                ],
                [
                    "group" => "categories_fields_section",
                    "routes" => ["admin.categories_fields.list", "admin.categories_fields.store",
                    "admin.categories_fields.update", "admin.categories_fields.destroy"]
                ],
                [
                    "group" => "user_types_doctments_section",
                    "routes" => ["admin.user.types.documents.create", "admin.user.types.documents.read",
                    "admin.user.types.documents.update", "admin.user.types.documents.delete"]
                ],
                [
                    "group" => "user_types_section",
                    "routes" => ["admin.usertype.create", "admin.usertype.read",
                    "admin.usertype.update", "admin.usertype.delete"]
                ],
                [
                    "group" => "users_section",
                    "routes" => ["admin.users.list.verified", "admin.users.list.pending",
                    "admin.users.decide.pending", "admin.users.assign.career", "admin.users.change.status",
                    "admin.users.send.mail", "admin.users.get.user"]
                ],
                [
                    "group" => "settings_frontgroups",
                    "routes" => ["admin.groups.create", "admin.groups.list.all",
                    "admin.groups.update", "admin.groups.delete"]
                ]
            ];

            return $all_permissions;
        }
    }
/** Close Admin-User Prmissions */

/** Admin-User Role Activities */
    if (!function_exists("admin_role_activities")) {
        function admin_role_activities($user,$action, $activities = null) {

            if($activities){
                $activities = json_decode($activities);
                array_push($activities, [
                    "user"=> $user,
                    "action"=> $action,
                    "date" => Carbon::now(),
                ]);
                return json_encode($activities);
            }

            return json_encode([
                [
                    'user'=> 'system',
                    'action'=> $action,
                    'date'=> Carbon::now(),
                ]
            ]);
        }
    }
/** Close Admin-User Role Activities  */

/** Admin-User Filter List Permissions with only routes */
    if (!function_exists('Admin_Permissions_routes')) {
        function Admin_Permissions_routes() {
            return array_merge(...array_map(fn($item) => $item['routes'] ?? [], Admin_ListPermissions()));
        }
    }
/** Close Admin-User Filter List Permissions with only routes */

<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        \Encore\Admin\Auth\Database\Menu::truncate();
        \Encore\Admin\Auth\Database\Menu::insert(
            [
                [
                    "parent_id" => 0,
                    "order" => 10,
                    "title" => "Products",
                    "icon" => "fa-list",
                    "uri" => "products",
                    "permission" => NULL
                ],
                [
                    "parent_id" => 0,
                    "order" => 10,
                    "title" => "Categories",
                    "icon" => "fa-list",
                    "uri" => "categories",
                    "permission" => NULL
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Permission::truncate();
        \Encore\Admin\Auth\Database\Permission::insert(
            [
                [
                    "name" => "CATEGORIESList",
                    "slug" => "categories.list",
                    "http_method" => "GET",
                    "http_path" => "/categories"
                ],
                [
                    "name" => "CATEGORIESView",
                    "slug" => "categories.view",
                    "http_method" => "GET",
                    "http_path" => "/categories/*"
                ],
                [
                    "name" => "CATEGORIESCreate",
                    "slug" => "categories.create",
                    "http_method" => "POST",
                    "http_path" => "/categories"
                ],
                [
                    "name" => "CATEGORIESEdit",
                    "slug" => "categories.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/categories/*"
                ],
                [
                    "name" => "CATEGORIESDelete",
                    "slug" => "categories.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/categories/*"
                ],
                [
                    "name" => "CATEGORIESExport",
                    "slug" => "categories.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "CATEGORIESFilter",
                    "slug" => "categories.filter",
                    "http_method" => "GET",
                    "http_path" => "/categories"
                ],
                [
                    "name" => "FAILED-JOBSList",
                    "slug" => "failed-jobs.list",
                    "http_method" => "GET",
                    "http_path" => "/failed-jobs"
                ],
                [
                    "name" => "FAILED-JOBSView",
                    "slug" => "failed-jobs.view",
                    "http_method" => "GET",
                    "http_path" => "/failed-jobs/*"
                ],
                [
                    "name" => "FAILED-JOBSCreate",
                    "slug" => "failed-jobs.create",
                    "http_method" => "POST",
                    "http_path" => "/failed-jobs"
                ],
                [
                    "name" => "FAILED-JOBSEdit",
                    "slug" => "failed-jobs.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/failed-jobs/*"
                ],
                [
                    "name" => "FAILED-JOBSDelete",
                    "slug" => "failed-jobs.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/failed-jobs/*"
                ],
                [
                    "name" => "FAILED-JOBSExport",
                    "slug" => "failed-jobs.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "FAILED-JOBSFilter",
                    "slug" => "failed-jobs.filter",
                    "http_method" => "GET",
                    "http_path" => "/failed-jobs"
                ],
                [
                    "name" => "MIGRATIONSList",
                    "slug" => "migrations.list",
                    "http_method" => "GET",
                    "http_path" => "/migrations"
                ],
                [
                    "name" => "MIGRATIONSView",
                    "slug" => "migrations.view",
                    "http_method" => "GET",
                    "http_path" => "/migrations/*"
                ],
                [
                    "name" => "MIGRATIONSCreate",
                    "slug" => "migrations.create",
                    "http_method" => "POST",
                    "http_path" => "/migrations"
                ],
                [
                    "name" => "MIGRATIONSEdit",
                    "slug" => "migrations.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/migrations/*"
                ],
                [
                    "name" => "MIGRATIONSDelete",
                    "slug" => "migrations.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/migrations/*"
                ],
                [
                    "name" => "MIGRATIONSExport",
                    "slug" => "migrations.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "MIGRATIONSFilter",
                    "slug" => "migrations.filter",
                    "http_method" => "GET",
                    "http_path" => "/migrations"
                ],
                [
                    "name" => "PASSWORD-RESETSList",
                    "slug" => "password-resets.list",
                    "http_method" => "GET",
                    "http_path" => "/password-resets"
                ],
                [
                    "name" => "PASSWORD-RESETSView",
                    "slug" => "password-resets.view",
                    "http_method" => "GET",
                    "http_path" => "/password-resets/*"
                ],
                [
                    "name" => "PASSWORD-RESETSCreate",
                    "slug" => "password-resets.create",
                    "http_method" => "POST",
                    "http_path" => "/password-resets"
                ],
                [
                    "name" => "PASSWORD-RESETSEdit",
                    "slug" => "password-resets.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/password-resets/*"
                ],
                [
                    "name" => "PASSWORD-RESETSDelete",
                    "slug" => "password-resets.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/password-resets/*"
                ],
                [
                    "name" => "PASSWORD-RESETSExport",
                    "slug" => "password-resets.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "PASSWORD-RESETSFilter",
                    "slug" => "password-resets.filter",
                    "http_method" => "GET",
                    "http_path" => "/password-resets"
                ],
                [
                    "name" => "PRODUCT-IMAGESList",
                    "slug" => "product-images.list",
                    "http_method" => "GET",
                    "http_path" => "/product-images"
                ],
                [
                    "name" => "PRODUCT-IMAGESView",
                    "slug" => "product-images.view",
                    "http_method" => "GET",
                    "http_path" => "/product-images/*"
                ],
                [
                    "name" => "PRODUCT-IMAGESCreate",
                    "slug" => "product-images.create",
                    "http_method" => "POST",
                    "http_path" => "/product-images"
                ],
                [
                    "name" => "PRODUCT-IMAGESEdit",
                    "slug" => "product-images.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/product-images/*"
                ],
                [
                    "name" => "PRODUCT-IMAGESDelete",
                    "slug" => "product-images.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/product-images/*"
                ],
                [
                    "name" => "PRODUCT-IMAGESExport",
                    "slug" => "product-images.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "PRODUCT-IMAGESFilter",
                    "slug" => "product-images.filter",
                    "http_method" => "GET",
                    "http_path" => "/product-images"
                ],
                [
                    "name" => "PRODUCTSList",
                    "slug" => "products.list",
                    "http_method" => "GET",
                    "http_path" => "/products"
                ],
                [
                    "name" => "PRODUCTSView",
                    "slug" => "products.view",
                    "http_method" => "GET",
                    "http_path" => "/products/*"
                ],
                [
                    "name" => "PRODUCTSCreate",
                    "slug" => "products.create",
                    "http_method" => "POST",
                    "http_path" => "/products"
                ],
                [
                    "name" => "PRODUCTSEdit",
                    "slug" => "products.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/products/*"
                ],
                [
                    "name" => "PRODUCTSDelete",
                    "slug" => "products.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/products/*"
                ],
                [
                    "name" => "PRODUCTSExport",
                    "slug" => "products.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "PRODUCTSFilter",
                    "slug" => "products.filter",
                    "http_method" => "GET",
                    "http_path" => "/products"
                ],
                [
                    "name" => "USERSList",
                    "slug" => "users.list",
                    "http_method" => "GET",
                    "http_path" => "/users"
                ],
                [
                    "name" => "USERSView",
                    "slug" => "users.view",
                    "http_method" => "GET",
                    "http_path" => "/users/*"
                ],
                [
                    "name" => "USERSCreate",
                    "slug" => "users.create",
                    "http_method" => "POST",
                    "http_path" => "/users"
                ],
                [
                    "name" => "USERSEdit",
                    "slug" => "users.edit",
                    "http_method" => "PUT,PATCH",
                    "http_path" => "/users/*"
                ],
                [
                    "name" => "USERSDelete",
                    "slug" => "users.delete",
                    "http_method" => "DELETE",
                    "http_path" => "/users/*"
                ],
                [
                    "name" => "USERSExport",
                    "slug" => "users.export",
                    "http_method" => "GET",
                    "http_path" => ""
                ],
                [
                    "name" => "USERSFilter",
                    "slug" => "users.filter",
                    "http_method" => "GET",
                    "http_path" => "/users"
                ]
            ]
        );

        \Encore\Admin\Auth\Database\Role::truncate();
        \Encore\Admin\Auth\Database\Role::insert(
            [

            ]
        );

        // pivot tables
        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [

            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [

            ]
        );

        // finish
    }
}

# How to start

```shell
git clone git@github.com:leobeal/api_demo.git
cd api_demo

composer install

```

#Routes available
![routes](public/images/routes.png)


#Online example

A working version of this demo can be found in [https://leobeal.com](https://leobeal.com)

## Using Postman

A Json postman colletion is available for convinient testing of the application.
It can be found [here](public/postman_collection.json) or [here](https://leobeal.com/postman_collection.json)


#Docs
Api docs are available under /docs.  Calls made to the api from docs might not work, as authentication is required. Use postman instead.

#Permissions
- Admins can create products and bundles.
- Normal users can see products, add a product to a cart, and create an order.

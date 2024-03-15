# Yii2-Test

This is a Yii2 app that extracts data from Open Exchange Rates API and in order to make it work you must sign up and obtain a free key, https://openexchangerates.org/signup/free 
1)	First Install XAMPP on your computer
2)	Install composer (https://getcomposer.org/download/)
3)	Go to the folder of htdocs and run this command 
composer create-project --prefer-dist yiisoft/yii2-app-basic name_of_the_project
4)	Access Yii2 project http://localhost/ name_of_the_project /web/
5) Run the currencyController and the import function that are within the command folder with this command: php yii currency/import. You can define specific dates,php yii currency/import "2024-03-01" "2024-03-12.
6) Enjoy!!

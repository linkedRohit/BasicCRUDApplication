Author: Prabin

This is a utility bundle compatible with symfony 2.3 and above versions. Functionalities are listed below

How to include the bundle:
- copy/export/link as svn external this bundle folder "UtilityBundle" at src/Naukri/
- In your application AppKernel.php, in function registerBundles() add the following
  new Naukri\UtilityBundle\NaukriUtilityBundle(),


Functionalities:
All functionalities available with this Utility bundle are not enabled by default when the bundle is included.
Some of the functionalities require some changes in your code to enable the same.
It has been done to allow individual application to control what they want

1) Custom render tag for smarty.
    Smarty bundle has a bug because of which render tag gives an error.
    To fix that a custom render tag has been introduced with tag name "_nrender"
    How to use:
        - pre enabled. just use as
        ~_nrender`<your route name>~/_nrender`

2) Registering php classes to smarty. Use case: using php constants or static functions directly in smarty
    How to register classes:
        - in parameters.yml of your application add the following
            smarty.overrides:
                register.classes:
                    <class name>: <bundle path of your class>

            example:
                smarty.overrides:
                    register.classes:
                        MyClass: Naukri\MyBundle\Resources\model\MyClass

    How to use:
        We can use only the registered classes in smarty (done via as shown above).
        A constant in the registered class can be used directly in smarty as:
        -
             ~MyClass::myConstant` or ~MyClass::myStaticMethod($arg)`

3) Custom Error pages in smarty
    We generally need to display error pages like 404, 403 etc in a theme similar to the application.
    How to enable:
        In config.yml -
        Add the following under twig as :
        twig:
            exception_controller: NaukriUtilityBundle:NaukriException:show
    How to use:
        - Create a folder called "Exception" containing the error templates
          as Naukri\<your bundle>\Resourses\views\Exception

        - Create your custom error templates here. 
        - Make a template as error.html.tpl: this will be default template for all your errors
        - For custom error make templates as error<error code>.html.tpl 
          eg: error404.html.tpl : this template will be used to display 404 errors

        In your deploy script simlink the folder
        Naukri\<your bundle>\Resourses\views\Exception to Naukri\UtilityBundle\Resourses\views\Exception
      

4) Asset extention for easy versioning of css and js
    How to use:
        - Create assetVersions.yml file anywhere, and include in your config.
        - Define the paths for your assets in your config with names
          NC_JS_PATH : for naukri common js
          AC_JS_PATH : for application js
          NC_CSS_PATH : for naukri common css
          AC_CSS_PATH : for application css
        - it should contain data as in the example below
        parameters:   
            asset.version:
                script.version:
                    someScript: 
                      name: "someScript_v1.4.js"
                      type: "NC"
                    
                    add more as per your requirement

                css.version:
                    someCSS: 
                      name: "someCSS_v1.9.css"
                      type: "AC"
                    
                    add more as per your requirement

         Now in your templates you can simply use the assets as
         ~_nscript`someScript~/_nscript`
         ~_ncss`someCSS~/_ncss`


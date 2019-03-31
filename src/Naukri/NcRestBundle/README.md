# Bundle setup

* Go to the base level of your project and run the command: 
```
  git subtree add --prefix src/Naukri/NcRestBundle http://gitlab.infoedge.com/naukrilibs/ncrestbundle.git  master --squash -m 'your comment here' 
```
  where src/Naukri directory contains your bundles. Replace it with the appropriate path.

* Regsiter the bundle in AppKernel.php 
    Add the following line at the end of the function registerBundles:
    ```php
      new Naukri\NcRestBundle\NaukriNcRestBundle()
    ```

# Usage

* Your controller should implement NcApiControllerInterface:
   i.e. 

    ```php
        use Naukri\NcRestBundle\Controller\NcApiControllerInterface;
        class MyController implements NcApiControllerInterface{ your code here..}
    ```
* Define a global constant named: `NCREST_REFERER_URL_SUBSTR`
   This constant should contain comma separated (omit comma if using only a single value) strings that must be a part of the url of your api. We need to do this, as we want our listener to work only for the rest api urls. e.g. In case of apply, I know that the url would definitely contain a substring named "applyapi", then I defined this constant as:
    
    ```php
        define("NCREST_REFERER_URL_SUBSTR","myapi");
    ```

    If your apis donot contain a common substring, you can set multiple substrings here (comma separated)
    
    ```php
        define("NCREST_REFERER_URL_SUBSTR","myapi,myotherapi");
    ```

* The bundle allows: `"application/xml","application/json","multipart/form-data", "application/json; charset=UTF-8"` as accept type and content type.

*  In case, there is an `error in the format of accept type or content type` passed, a response with appropriate headers indicating the error will be returned:
    e.g. 
    If you pass application/atom+xml in content type, which is not allowed, the response returned would be:
   ```json
   {
    error: {
      status: 415
      message: "Unsupported Media Type"
      code: 4015
    }
   }
   ```
  and the `header` status would be: `415 Unsupported Media Type`
  
  You can play around this and see what type of response is returned on each request.

* All validations will have to be checked by the application itself. In case, validations fails, you will need to throw a new Exception:
 
   ```php
    throw new ApiException($arrValidationErrors, $customData(optional), $appCode(optional));
   ```

   ```php
    $arrValidationErrors contains all the validation errors in the complete flow. $arrValidationErr contains error for a particular field. 
    $arrValidationErrors is an array of $arrValidationErr.
   ```

   The `format of the array arrValidationErrors` should be:
   
   ```php
    $arrValidationErr["field"] -> which should contain the field name for which validations failed. e.g. email
    $arrValidationErr["errorMessage"] -> which should contain the error message for the field. e.g. Email length should be less than 250 characters.
    $arrValidationErr["errorCode"] -> which should contain the error code for the field. It could be anything. e.g. 789
   ```

   To make things more clear, what I mean by saying $arrValidationErrors is an array of $arrValidationErr:
   
   ```php 
        $arrValidationErrors[] = $arrValidationErr;
   ```

   To use ApiException write a use statement:
   
   ```php 
    use Naukri\InterceptBundle\Services\Api\ApiException;
   ```

*  If everything has passed, you now need to return a `success message`. 
    For this, you will have to `make an array of the resultset` you want to return, lets say the name of this array is arrResult, then write:
    
```php
    return ApiResponseUtil::returnSuccessResponse($arrResult, $responseCode, $responseFormat);
    /** where responseCode is optional and defaults to 200
     *  and responseFormat is optional and default to json
    **/
```

    and the use statement for this would be:
```php
    use Naukri\NcRestBundle\Utility\ApiResponseUtil;
```

* UTs: As nc rest throws custom headers, we do not want symfony headers to be thrown, so response is not returned by symfony controller. It is rather returned by ncrestbundle itself.
  This makes it difficult to write ITs as, there is a die statement in ncrest, after throwing the response and headers.
  If you want to write ITs for apis built with ncrest, you need to define a constant : 

    ```php
        define("UT_COVERAGE",1);
    ```
    If you have defined this constatn, then ncrest would not execute die statement. It will return the response rather.
    
* Supressing Code in output: If you want to supress code in error output of ncrest, define another constant to do so:

    ```
        define("NCREST_SHOW_CODE", 0);
    ```
    By default, codes are shown. To supress code, set the constant to 0.
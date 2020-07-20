# Rest API
Rest Api is another way to use the PSMT package. It controls the PSMT & fileHandler class.

## Authorization
For Set basic authentication simply open `authorization-sample.php` in a text editor, fill in your authentications, and save it as `authorization.php`.
**Syntax**
```php
$Authorization = array(
    array(
        'authlevel' => 10,
        'user' => 'root',
        'password' => '63a9f0ea7bb98050796b649e85481845' 
    ),
    ... # More Arrays like that 

);
define('Authorization', $Authorization);
```

**Keys**
- **authlevel*** - Required.  Authorization level for defining user permissions.
*Example -* `10`
- **user*** - Required. Username for identifying the user.
*Example -* `root`
- **password*** - Required. Password for verifying user. Must be md5 hash
*Example -* `63a9f0ea7bb98050796b649e85481845`

## Methods

1. **GET** - for fetch details 
2. **POST** - for do changes
       1. **?put** - for create actions
       2. **?patch** - for update actions
       3. **?delete** - for delete actions

## Get API 's
GET request call only read methods.

**API** - `{Path}/api?{keys}`

### Read file -
This request renders files. It will use `PSMT.php` read method. [Read more](PSMT.md#read())

**Syntax**
`{Path}/?file={filename}`

**Keys**
-  **filename*** - Required. Specifies the name or id of the file to read.
*Example -* `I200706141626ce9c.jpg`

**Authlevel** - `0`

### Read file properties -
This request returns file properties. It will use `PSMT.php` read method.[Read more](PSMT.md#read())

**Syntax**
`{Path}/?file={filename}&properties`

**Keys**
-  **filename*** - Required. Specifies the name or id of the file to read.
*Example -* `I200706141626ce9c.jpg`
- **properties*** -  Required. For returning properties.
*Example -* ` `

**Authlevel** - `0`

**Return**
*Example ({Path}/?file=I200706141626ce9c.jpg&properties) -*
Then It will return the JSON log.
```json
{
    "exits": true,
    "name": "I200706141626ce9c.jpg",
    "type": "image/jpeg",
    "size": "1.42 MB",
    "parent_folder": "---/PSMT/Storage/Image",
    "location": "---/PSMT/Storage/Image/I200706141626ce9c.jpg",
    "accessed_date": "---",
    "modified_date": "---",
    "permissions": "0777"
}
```
### Force download file  -
This request force download files. It will use `PSMT.php` download method. [Read more](PSMT.md#download())

**Syntax**
`{Path}/?file={filename}&download`

**Keys**
-  **filename*** - Required. Specifies the name or id of the file to read.
*Example -* `200706141626ce9c.jpg`
- **download*** -  Required. For force download.
*Example -* ` `

**Authlevel** - `0`

**Return**
*Example ({Path}/?file=I200706141626ce9c.jpg&download) -*
It will force download that file.

### Ls -
This request shows a simple list of files and directories. It will use `fileHandler.php` ls method. [Read more](fileHandler.md#ls())

**Syntax**
`{Path}/?ls={path or identifier}`

**Keys**
- **ls*** -  Required. Specifies the Identifier or the path of the folder and directory.
*Example -* `V` or `Storage`

**Authlevel** - `1`

**Return**
*Example ({Path}/?ls=V) -*
It will return a long list of files and directories In JSON format.
```json
[
    ".",
    "..",
    "V2007061415172cab-high.mp4",
    "V2007061415172cab.mp4",
    "V2007061415172cab-low.mp4",
    "V200706141555e6ff-high.mp4",
    "V200706141555e6ff.mp4",
    "V200706141555e6ff-low.mp4",
    "V200706141626ce9c-high.mp4",
    "V200706141626ce9c.mp4",
    "V200706141626ce9c-low.mp4"
]
 ```
 
### Check file -
This request check file exists, readable, writable, executable, or not. And the path of that file. It will use `fileHandler.php` check_file method. [Read more](fileHandler.md#check_file())

**Syntax**
`{Path}/?check_file={filename}`

**Keys**
- **filename** - Required. Specifies the path to the file or filename (organized file with Identifier) to get details.
*Example -* `V2007061415172cab.mp4`

**Authlevel** - `1`

**Return**
It will return the JSON log.
*Example ({Path}/?check_file=V2007061415172cab.mp4)-*
```json
{
    "file_path": "/Storage/Video/V2007061415172cab.mp4",
    "file_exist": true,
    "readable": true,
    "writeable": true,
    "executable": true

}
```

### Log read -
This request read or display stored logs in JSON format. It will use `logHandler.php` load_read method. [Read more](logHandler.md#log_read())

**Syntax**
`{Path}/?log_read`

**Keys**
- **log_read** - Required.  For Request
*Example -* ` `

**Authlevel** - `1`

**Return**
*Example ({Path}/?log_read)-*
It will return stored logs in JSON format.

## Post - '?put' Api's

POST ?put request call put/create related methods.

**API** - `{Path}/?put`
**Authlevel** - `2`

### Upload - 
This request upload files with direct file or links. It will use `PSMT.php` upload method. [Read more](PSMT.md#upload())

**Keys**
- **file** - Required. Specifies the file or URL (must be direct link and extension at the end of the URL) to upload. 
*Example -* `{FILE}` or `https://www.google.com/images/branding/googlelogo/1x/googlelogo_color_272x92dp.png`

**Return**
It will return the JSON log.
*Example (Image uploading with enable transcoder)-*
```json
[
    {
        "Type": "Log",
        "DateTime": "---",
        "IPaddress": "---",
        "Function": "upload()",
        "Message": "4K-Wallpaper-3840x2160.jpg successfully uploaded. New Path : /opt/lampp/htdocs/PSMT/Storage/Image/I2007061904425a7b.jpg",
        "Return": {
            "status": "success",
            "oldFileName": "4K-Wallpaper-3840x2160.jpg",
            "fileName": "I2007061904425a7b.jpg",
            "fileType": "image",
            "fileSize": 1483888,
            "location": "/opt/lampp/htdocs/PSMT/Storage/Image/I2007061904425a7b.jpg"
        }
    },
    {
        "Type": "Log",
        "DateTime": "---",
        "IPaddress": "---",
        "Function": "transcode()",
        "Message": "I2007061904425a7b.jpg successfully transcoded.",
        "Return": {
            "status": "success",
            "files": {
                "high": "I2007061904425a7b-high.jpg",
                "low": "I2007061904425a7b-low.jpg"
            }
        }
    }
]

```

### Create - 
This request creates files.  It will use `fileHandler.php` create method. [Read more](fileHandler.md#create())

**Keys**
- **create*** - Required. Specifies the directory or file path to create.
*Example -* `text.txt`
- **fill** - Optional. Specifies the string to write to the create file. By default it takes Null.
- **chmod**- Optional. Specifies the chmod permissions for creating files or directory. By default, it takes `0777`.

**Return**
It will return the JSON log.
*Example (`/Compressed` creating a directory)-*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "create()",
    "Message": "/Compressed Created successfully.",
    "Return": null
}]
```

## Post - '?patch' Api's

POST ?patch request call patch/edit related methods.

**API** - `{Path}/?patch`
**Authlevel** - `2`

### Transcode - 
This request transcodes files.  It will use `PSMT.php` transcode method. [Read more](PSMT.md#transcode())

**Keys**
- **transcode*** -  Required. For request.
*Example -* ` `
- **file*** - Required. Already exists & organized file name or id.
*Example -* `I2007061904425a7b.jpg`

**Return**
It will return the JSON log. 
*Example (Image transcoding)-*
```json
[
    {
        "Type": "Log",
        "DateTime": "---",
        "IPaddress": "---",
        "Function": "transcode()",
        "Message": "I2007061904425a7b.jpg successfully transcoded.",
        "Return": {
            "status": "success",
            "files": {
                "high": "I2007061904425a7b-high.jpg",
                "low": "I2007061904425a7b-low.jpg"
            }
        }
    }
]
```

### Writes - 
This request write files.  It will use `fileHandler.php` write method. [Read more](fileHandler.md#write())

**Keys**
- **write*** - Specifies the filename (organized file with Identifier) or the path of the folder and directory.
*Example -* `V2007061415172cab.mp4`  or `Test/text.txt`
- **fill*** - Required. Specifies the string to write to the open file.
*Example -* `Hello Text`
- **mode** - Optional. Specifies the type of access you require to the file/stream. Values are the same as the PHP open mode value. By default value `a`.
*Example -* `w`

**Return**
It will return the JSON log.
*Example (`text.txt` writing `Hello Text` file inside the file.) -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "write()",
    "Message": "text.txt Write successfully.",
    "Return": null
}]
```

### CP -
This request copy files.  It will use `fileHandler.php` copy method. [Read more](fileHandler.md#cp())

**Keys**
- **cp*** - Required. Specifies the filename (organized file with Identifier) or the path to the file to copy from.
*Example -* `V2007061415172cab.mp4`  or `Text.txt`
- **dst*** - Required. Specifies the path to the file to copy to. Remember to write from_file filename again after to_file path like `to_file + / + from_file`.
*Example -* `Movie/V2007061415172cab.mp4` or `Text/text.txt`

**Return**
It will return the JSON log.
*Example (`readme.md` copy into `Docs/` directory) -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "cp()",
    "Message": "readme.md Copied successfully to Docs/readme.md.",
    "Return": null

}]
```

### MV -
This request moves files.  It will use `fileHandler.php` move method. [Read more](fileHandler.md#mv())

**Keys**
- **mv*** - Required. Specifies the filename (organized file with Identifier) or the path to the file to move from.
*Example -* `V2007061415172cab.mp4`  or `Test/`
- **dst*** - Required. Specifies the path to the file to move to. Remember to write from_file filename again after to_file path like `to_file + / + from_file`.
*Example -* `Movie/V2007061415172cab.mp4` or `Text/`

**Return**
It will return JSON log.
*Example (`Test/` moving into `New/` directory) -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "mv()",
    "Message": "Test/ Moved successfully to New/.",
    "Return": null

}]
```
## POST - '?delete' Api's
POST ?delete request call delete/remove related methods.

**API** - `{Path}/?delete`
**Authlevel** - `3`

### RM -
This request removes files.  It will use `fileHandler.php` rm method. [Read more](fileHandler.md#rm())

**Keys**
- **rm*** - Required. Specifies the path to the file or filename (organized file with Identifier) to delete.
*Example -* `V2007061415172cab.mp4`  or `text.txt`
- **confirm*** - Required. As confirmation that method/functions. It takes a `1` or `y` as a confirmation.
*Example -* `1`

**Return**
It will return the JSON log.
*Example (Remove `text.txt`) -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "rm()",
    "Message": "text.txt deleted successfully.",
    "Return": null
}]
```

### rmdir - 
This request removes directory files.  It will use `fileHandler.php` rmdir method. [Read more](fileHandler.md#rmdir())

**Keys**
- **rmdir*** - Required. Specifies the path to the directory to delete the whole directory.
*Example -* `Test/`
- **confirm*** - Required. As confirmation that method/functions. It takes a `1` or `y` as a confirmation.
*Example -* `1`

**Return**
It will return JSON log.
*Example (Remove `text/`directory ) -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "rmdir()",
    "Message": "Test directory deleted successfully.",
    "Return": null
}]
```

### clear_temp - 
This request clear_temp directory files.  It will use `fileHandler.php` clear_temp method. [Read more](fileHandler.md#clear_temp())

**Keys**
- **clear_temp*** - Required. For request.
*Example -* ` `
- **confirm*** - Required. As confirmation that method/functions. It takes a `1` or `y` as a confirmation.
*Example -* `1`

**Return**
It will return the JSON log.
*Example -*
```json
[{
    "Type": "Log",
    "DateTime": "---",
    "IPaddress": "---",
    "Method": "clear_temp()",
    "Message": "Temp cleared successfully.",
    "Return": null
}]
```
### log_clear - 
This request log_clear directory files.  It will use `logHandler.php` log_clear method. [Read more](logHandler.md#clear_temp())

**Keys**
- **log_clear*** - Required. For request.
*Example -* ` `
- **confirm*** - Required. As confirmation that method/functions. It takes a `1` or `y` as a confirmation.
*Example -* `1`

**Return**  
It will return the JSON log.  
*Example -*  

```json  
[{  
    "Type": "Log",  
    "DateTime": "---",  
    "IPaddress": "---",  
    "Method": "clear_temp()",  
    "Message": "Temp cleared successfully.",  
    "Return": null  
}]  
```

## Add New REST API
You can also create or add your own Rest API class or library. [Read More](customized.md)

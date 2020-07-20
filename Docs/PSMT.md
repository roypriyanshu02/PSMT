# PSMT - Main Class
PSMT is the main class of this package that handles all other classes like Handler, Read, or Processor classes. In your project, you just need to include it. Then you can access all methods/functions of PSMT expect file-handler methods/functions. 

## Config
You should check out `config.md` for configuring PSMT or other classes. [Read More](config.md)

## read()
The read method renders or checks any file properties by their filename. If there any specific Read class exists for that identifier then it will render by using that class or library like `imageRead.class.php`.  Else it uses default Read class `otherRead.class.php`.
You can also create or add your own Read class or library [read more](/ownclass).

**Syntax**
```php 
read(string $filename,int $properties)
``` 
**Parameters**
- **filename*** - Required. Specifies the name or id of the file to read.
*Example -* `I200706141626ce9c.jpg`
- **properties** - Optional. If you want to check any file properties, then you put any int or boolean value.
*Example -* `NULL` or `false`

**Return**
It will render that file.
*Example (Read an image file) -*

*Example (Read an image file properties) -*
Then It will return JSON log.
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

## download()
The download method generator forces download by their filename or id. It supports all identifiers. 

**Syntax**
```php 
download(string $filename)
``` 
**Parameters**
- **filename*** - Required. Specifies the name or id to the file to download.
*Example -* `I200706141626ce9c.jpg`

**Return**
It will force download that file.
*Example (Download an image file) -*


## upload()
The upload method handles file uploads, Generates a unique filename or id, and organizes them by a defined identifier. It can automatically run transcode() method after file uploading and organize.

**Syntax**
```php
upload(string $file)
```
**Parameters**
- **file*** - Required. Specifies the file or URL (must be direct link and extension at the end of the URL) to upload.
*Example -* `$_FILE['file]` or `{https://www.google.com/images/branding/googlelogo/2x/googlelogo_color_92x30dp.png}`

**Return**
It will return JSON log.
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
## transcode()
The Transcode method transcodes the file. If there any specific Processor class exists or enables for that identifier then it will transcode by using that class or library like `videoProcessor.class.php`.
You can also create or add your own Processor class or library [read more](customized.md).

**Syntax**
```php
transcode(string $filename,int $auto=NULL)
```
**Parameters**
- **filename*** - Required. Already exists & organized file name or id.
*Example -* `I200706141626ce9c.jpg`
- **auto** - Not required. You don't need to fill it. It's work when another function call transcode() method. It works for blocking extra logs.

**Return**
It will return JSON log. 
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

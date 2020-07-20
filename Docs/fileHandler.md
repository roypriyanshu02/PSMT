# FileHandler
File Handler is a class that Handles file handling like list, write, remove, permissions, etc. Recommend to use filehandler methods for PSMT file-handling. It works perfectly with organized files by identifier. In your project, you just need to include it. Then you can access all methods/functions of the PSMT FileHandler class.

## Config
You should check out `config.md` for configuring PSMT or other classes. [Read More](config.md)

## ls()
`ls` It will show a simple list of files and directories. List files and directories in a bare format where we won’t be able to view details like file types, size, modified date and time, permission and links, etc.
**Syntax**
```php
ls(string $pname)
```

**Parameters**
- **pname*** -  Required. Specifies the Identifier or the path of the folder and directory.
*Example -* `V` or `Storage`

**Return**
It will return a long list of files and directories In JSON format.
 *Example (list of v identifier directory)-*
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
 
## create()
Create is a method to create new files or directory. We were also able to create files with content by using a fill `$content` parameter.

 **Syntax**
```php
create(string $pathname,string $content,int $chmod)
```

**Parameters**
- **pathname*** - Required. Specifies the directory or file path to create.
*Example -* `Storage/Compressed`
- **content** - Optional. Specifies the string to write to the create file. By default it takes Null.
- **chmod**- Optional. Specifies the chmod permissions for creating files or directory. By default, it takes `0777`.

**Return**
It will return JSON log.
*Example (`Storage/Compressed` creating a directory)-*
```json
[{
	"Type": "Log",
	"DateTime": "---",
	"IPaddress": "---",
	"Method": "create()",
	"Message": "Storage/Compressed Created successfully.",
	"Return": null
}]
```
## write()
Write is a method to write the contents of the string into the selected file. It works similarly to PHP `fwrite()`.

 **Syntax**
```php
write(string $pathname,string $content,string $mode)
```

**Parameters**
- **pathname*** - Specifies the filename (organized file with Identifier) or the path of the folder and directory.
*Example -* `V2007061415172cab.mp4`  or `Test/text.txt`
- **content*** - Required. Specifies the string to write to the open file.
*Example -* `Hello Text`
- **mode** - Optional. Specifies the type of access you require to the file/stream. Values are the same with the PHP open mode value. By default value `a`.
*Example -* `w`

**Return**
It will return JSON log.
*Example (`Test/text.txt` writing `Hello Text` file inside the file.) -*
```json
[{
	"Type": "Log",
	"DateTime": "---",
	"IPaddress": "---",
	"Method": "write()",
	"Message": "Test/text.txt Write successfully.",
	"Return": null
}]
```

## mv()

MV stands for the move. The move is a method to move files or directories from one place to another in the file system like Unix Or Linux. It's will also useful for renaming files or directories.

 **Syntax**
```php
mv(string $from_file, string $to_file)
```

**Parameters**
- **from_file*** - Required. Specifies the filename (organized file with Identifier) or the path to the file to move from.
*Example -* `V2007061415172cab.mp4`  or `Test/`
- **to_file*** - Required. Specifies the path to the file to move to. Remember to write from_file filename again after to_file path like `to_file + / + from_file`.
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

## cp()
CP stands for the copy. The cp is a method to copy files or directory. It creates an exact image of a file with a different file name.

 **Syntax**
```php
cp(string $from_file, string $to_file)
```

**Parameters**
- **from_file*** - Required. Specifies the filename (organized file with Identifier) or the path to the file to copy from.
*Example -* `V2007061415172cab.mp4`  or `Text.txt`
- **to_file*** - Required. Specifies the path to the file to copy to. Remember to write from_file filename again after to_file path like `to_file + / + from_file`.
*Example -* `Movie/V2007061415172cab.mp4` or `Text/text.txt`

**Return**
It will return JSON log.
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

## rm()
RM stands for remove here. The rm is a method to remove objects such as files, directories.

 **Syntax**
```php
rm(string $filename,int $confirmation)
```

**Parameters**
- **file*** - Required. Specifies the path to the file or filename (organized file with Identifier) to delete.
*Example -* `V2007061415172cab.mp4`  or `text.txt`
- **confirmation*** - Required. As confirmation that method/functions. It takes a `1` as a confirmation.
*Example -* `1`

**Return**
It will return JSON log.
*Example (remove `text.txt`) -*
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

## rmdir()
Rmdir stands for remove directories here. The rmdir is a method to remove directories or every file inside that directory.

 **Syntax**
```php
rmdir(string $directory,int $confirmation)
```

**Parameters**
- **directory*** - Required. Specifies the path to the directory to delete the whole directory.
*Example -* `Test/`
- **confirmation*** - Required. As confirmation that method/functions. It takes a `1` int as a confirmation.
*Example -* `1`

**Return**
It will return JSON log.
*Example (remove `text/`directory ) -*
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

## clear_temp()
Clear Temp is a method to clear `.temp` the directory in PSMT.

**Syntax**
  ```php
clear_temp()
```

**Return**
It will return JSON log.
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

## check_file()
Check_file is a method used to check is file exists, readable, writable, or executable. And the path of that file.


 **Syntax**
```php
check_file(string $pathname,int $auto)
```

**Parameters**
- **pathname** - Required. Specifies the path to the file or filename (organized file with Identifier) to get details.
*Example -* `V2007061415172cab.mp4`
- **auto** - Not required. You don't need to fill it. It's work when another function calls like write(). It works for blocking extra logs.

**Return**
It will return JSON log.
*Example ( `V2007061415172cab.mp4` file)-*
```json
{
	"file_path": "/Storage/Video/V2007061415172cab.mp4",
	"file_exist": true,
	"readable": true,
	"writeable": true,
	"executable": true

}
```

## chmod()
Chmod is a method used to change the access mode of files or directories.

 **Syntax**
```php
chmod(string $pathname,int $mode,int $confirmation)
```

**Parameters**
- **pathname*** - Specifies the filename (organized file with Identifier) or the path to the file or directory.
*Example -* `V2007061415172cab.mp4`  or `Test/`
- **confirmation*** - Required. As confirmation that method/functions. It takes a `1` as a confirmation.
*Example -* `1`

**Return**
It will return JSON log.
*Example (chmod 0777 `V2007061415172cab.mp4` file)-*
```json
[{
	"Type": "Log",
	"DateTime": "---",
	"IPaddress": "---",
	"Method": "chmod()",
	"Message": "V2007061415172cab.mp4 - video 0777 chmod successfully.",
	"Return": null
}]
```

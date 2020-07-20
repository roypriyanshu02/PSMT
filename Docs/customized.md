# Customized
In PSMT anyone can also add more Read, Processor, or Handler classes or libraries.

**Sub-Classess - **
1. **Read** - Classes made for rendering files, or any kind of reading functions. 
2. **Processor** - Classes made for processing (transcoding) files. 
3. **Handler** - Classes made for handling any kind of functions like Uploader, logger, etc.

**Package Rule** -
1. The class or Library must be inside `System/` Directory.
*example -* `System/imageRead.class.php`
2. The class name must be in camelcase & before extension should add `.class.`
*example -* `imageRead.class.php`

## How to add Read Classes
It's simple just create your own read class and add it inside the package by following rules.
Few more steps to add class inside the PSMT read method. Inside read method, add `else if` operator by the following syntax.

**Syntax**
```php 
elseif ($identifier['type']=={type}) {
	# Add own code for run created read method
}
``` 
*For the full path of file use this line -*
 `$identifier['directory'].$file # For full of path File`.

## How to add Processor Classes
It's simple just create an own Processor class and add it inside the package by following rules. 
Few more steps to add class inside the PSMT read method.  Inside read method, add `else if` operator a by the following syntax.


**Syntax for PSMT**
```php
elseif ($identifier['type']=={type}) {
	# Add own code for run created processor method
	# Logs Methods
}
```
*For the full path of file use this line -*
 `$identifier['directory'].$file # For full of path File`.
 
 *Recommended* to create an array for configuring created processor class inside `config.php`.
 
## How to add Handler Classes
It's simple just create an own Handler class and add it inside the package by following rules. Handler classes are independent, so add it in `PSMT.php` by creating a new method. Or make it a purely independent class. 
 *Recommended* to create an array for configuring created handler class inside `config.php`.

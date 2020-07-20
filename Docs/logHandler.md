# logHandler
logHandler is a subclass that Handles log related methods like display, storing, read stored and clear stored logs.

## Config
You should check out `config.md` for configuring PSMT or other classes. [Read More](config.md)

## create()

Create is a method to create logs. For saving and display logs in JSON format.

**Syntax**
```php
create(string $type,string $function,string $messages,string $return)
```
**Parameters**
- **type*** - Required. Type of log like Log, Warning, or Error.
*Example -* `log`
- **function*** - Required. The name of that function or method which is generating this log.
*Example -* `clear()`
- **messages*** - Required. Message or Details want to display or save in a log file.
*Example -* `Logs were cleared.`
- **return** - Optional. Here method or function outputs. Like Transcode new filenames or qualities etc.
*Example -* `array('status'=>'success')`

## read()
Read is a method to display saved or stored logs in JSON format.

**Syntax**
```php
read()
```
**Parameters**

Have no parameters.

**Return**
It will return stored logs in JSON format.

## clear()

Clear is a method to clear saved or stored logs.

**Syntax**
```php
clear(int $confirmation)
```
**Parameters**
- **confirmation*** - Required. As confirmation that method/functions. It takes a `1` as a confirmation.
*Example -* `1`

## How to access logHandler methods
How to get access or use logHandler methods. 

There two ways to access logHandler class.

1. It's already included In PSMT & fileHandler class as a subclass, access from there. *(recommended)*
	**Syntax**
	```php
	${Object}->log->{logHandler method}()
	```

2. It also separately by including only this class, but also should have to include `config.php` or manually config it.
	**Syntax**
	```php
	${Object}->{logHandler method}()
	```

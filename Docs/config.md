# Config
Config is a way to configure PSMT without add or remove any extra codes. You will find an array in `config.php` of PSMT for configuring classes or objects. 
*Recommend taking back-up of config.* Because updates might overwrite your settings configuration.

### 1. Identifier
The identifier is an array of defined file categories and set rules for organizing them.
**Syntax**
```php
'{SingleCharacter}' => array(
    'type' => '{FormatType}',
    'directory' => $StorageDirectory.'{Directory}/',
    'extensions' => array('{extensions1}', '{extensions2}', '{extensions3}'....),
    'minsize' => {int minsize},
    'maxsize' => {int maxsize}
),
... # More Arrays like that 
```

**Keys**
- **{SingleCharacter}** - As a title for Identify.
*Example -* `'I'`
    - **type** - File format type.
    *Example -* `'image'`
    - **directory** - Directory for that specific Identifier.
    *Example -* `true`
    - **extensions** - Allow Extensions.
    *Example -* `'jpg'`
    - **minsize** - Minimum file size allow.
    *Example -* `'minsize' => 3`
    - **maxsize** - Maximum file size allow.
    *Example -* `'maxsize' => 3 * 1000 * 1000 * 2`

### 2. Log Settings
The log array for configuring logs and organize them. It defines the log file where logs will save and it also sets enable or disable which type or function log want to save or display.
**Syntax**
```php
'file' => getcwd().'{Path}/',
'display' => {true/false},
'save' => {true/false},
'type_log' => array(
    'Log' => {true/false},
    'Warning' => {true/false},
    'Error' => {true/false} 
    ... # More Arrays like that 
),
'method_log' => array(
    '{function/method name()}' => {true/false},
    ... # More Arrays like that 
)
```
**Keys**
- **file** - For storing logs.
*Example -* `.log`
- **display** - Display current logs.
*Example -* `true`
- **save** - Wants to store logs.
*Example -* `true`
- **type_log** - Filter type of logs.
    - **log** - Successful logs.
    *Example -* `true`
    - **Warning** - User fault logs.
    *Example -* `true`
    - **Error** - System or package errors logs.
    *Example -* `true`
- **method_log** - Filter methods/functions logs.
*Example -* `'upload()' => true`

### 3. Transcoder Settings

Transcoder Settings for configuring Transcoders in PSMT.

#### 3.1. Image Transcoder

The Image Transcoder settings, configure Image Transcoder. It sets enable or disable Image-Transcoder, Directory for outputs and transcode formats and quality.

**Syntax**
```php
'enable' => {true/false},
'directory' => $this->identifier[{Identifier}]['directory'] or getcwd().'{Path}/',
'file_type' => array(
   '{format}',
   '{format 2}',
   '{format 3}'
   ...
),
'transcode' => array( # transcode name, format and qualitys
    '{name}' => array('c_type' => '{format}', 'level' => {int level}),
    '{name}' => array('c_type' => '{format}', 'level' => {int level})
    ...
)
```

**Keys**
- **enable** - For enable or disable image transcoder. 
*Example -* true
- **directory** - Directory for storing image transcoder outputs.
*Example -* `$this->identifier[{Identifier}]['directory']`
-  **file_type** - Allowing file formats. 
*Example -* 'jpg'
- **transcode** - Transcode name, format and qualitys.
    - **name** - Transcode format name.
    *Example -* 'high'
    - **c_type** - Transcode format. 
    *Example -* 'png'
    - **level** - Transcode level (1 to 10) . 
    *Example -* '5'

#### 3.2. Video Transcoder

The Video Transcoder settings, configure Video-Transcoder. It sets enable or disable Video-Transcoder, Directory for outputs and transcode - FFMPEG commands.

**Syntax**
```php
'enable' => {true/false},
'library' => '{Path}/ffmpeg',
'directory' => $this->identifier[{Identifier}]['directory'],
'transcode' => array(
    '{name}' => array(
        'c_type' => '{format}',
        'command' => '{ffmpeg command}'
    ),
    '{name}' => array(
       'c_type' => '{format}', 
       'command' => '{ffmpeg command}'
    )
    ...
)
```

**Keys**
- **enable** - For enable or disable video transcoder.
*Example -* `true`
- **library** - FFMPEG or other library path.
*Example -* `System/ffmpeg/ffmpeg`
- **directory** - Directory for storing video transcoder outputs.
*Example -* `$this->identifier[{Identifier}]['directory']`
- **transcode** - Transcode name, format and qualitys.
    - **name** - Transcode format name.
    *Example -* `'high'`
    - **c_type** - Transcode format.
    *Example -* `'mp4'`
    - **level** - Transcode FFmpeg command.
    *Example -* `'-s hd720 -b:v 5000K -bufsize 5000K -b:a 192K'`

#### 3.3. Audio Transcoder

The Audio Transcoder settings, configure Audio-Transcoder. It sets enable or disable Audio-Transcoder, Directory for outputs and transcode - FFMPEG commands.


**Syntax**
```php
'enable' => {true/false},
'library' => '{Path}/ffmpeg',
'directory' => $this->identifier[{Identifier}]['directory'],
'transcode' => array(
    '{name}' => array(
       'c_type' => '{format}', 
       'command' => '{ffmpeg command}'
    ),
   '{name}' => array(
       'c_type' => '{format}', 
       'command' => '{ffmpeg command}'
    )
    ...
)
```

**Keys**
- **enable** - For enable or disable audio transcoder.
*Example -* `true`
- **library** - FFMPEG or other library path.
*Example -* `'System/ffmpeg/ffmpeg'`
- **directory** - Directory for storing video transcoder outputs.
*Example -* `$this->identifier[{Identifier}]['directory']`
- **transcode** - Transcode name, format and qualitys.
    - **name** - Transcode format name.
    *Example -* `'high'`
    - **c_type** - Transcode format.
    *Example -* `'mp3'`
    - **level** - Transcode FFmpeg command.
    *Example -* `'-b:a 192K'`

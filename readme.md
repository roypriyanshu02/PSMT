![PHP Storage Manager and Transcoder (PSMT)](Docs/banner.jpg?raw=true)

This introduction to the PHP Storage Manager and Transcoder  (PSMT) is A Simple Object-Oriented library to manage or organize files and also convert/transcode files.

## Requirements
1. This version of the package is only compatible with PHP 7.2 or higher.
2. To use this package transcoder functions/objects, you need to install the FFmpeg For video and audio transcoding.

## Installation
Simple you have to download or clone this package in your project file or server and give it read, write & execute permissions and simply open `config-sample.php` in a text editor, fill in your [configuration](Docs/config.md), and save it as `config.php`. 

**Install FFmpeg -**. 
There two ways to install FFmpeg.

1. Install it your system *(recommended)*

2. Download the package file. 
	`FFmpeg static builds` Download it & put it inside the PSMT package `/System` folder.

After installing FFmpeg. You have to set up paths.
**Setup FFmpeg path -**
Open the PSMT package `config.php` file. Then search `Transcoder Settings`  there you can find a video or an audio transcoder settings array there you just have to change `library` key paths with your FFMPEG setup path. For *example* - `'library' => '{Your FFMPEG path.}',`
Simple.

## Quickstart

Include `autoload.php` in your project file.  Or use via REST API `api.php`.

## Documentations
**Main classes**
- [**PSMT** ](Docs/PSMT.md) - *For storage & file management & transcoder methods.* 
- [**config**](Docs/config.md) - *For configuring PSMT & other classes* 
- [**fileHandler**](Docs/fileHandler.md) - *For file or folder handling methods*
- [ **restapi**](Docs/restapi.md) - *For REST API to PSMT & fileHandler*

**Sub Classes**
- [**logHandler**](Docs/logHandler.md) - *For log handling methods*
- **uploadHandler** - *For upload handling methods*
- **propertiesRead** -*For reading properties method*
- **imageRead** - *For render images method*
- **audioRead** - *For render audios method*
- **documentRead** - *For render document method*
- **otherRead** -*For render all other method*
- **downloadRead** -*For generating downloads method*
- **imageProcessor** - *For transcode images method*
- **videoProcessor** - *For transcode videos method*
- **audioProcessor** - *For transcode audios method*


> Thank You  
> Happy Coding 😊
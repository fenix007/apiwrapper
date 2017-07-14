<?php

namespace Fenix007\Wrapper;

/**
 * Class Methods
 * @package Fenix007\Wrapper
 */
class Methods
{
    const TRANSLATIONS_GET_LIST = ['method' => 'GET', 'path' => '/streaming/translations.json'];
    const TRANSLATION_GET_INFO = ['method' => 'GET', 'path' => '/streaming/translations/{id}.json'];
    const TRANSLATION_DELETE = ['method' => 'DELETE', 'path' => '/streaming/translations/{id}.json'];
    const TRANSLATION_UPDATE = ['method' => 'PUT', 'path' => '/streaming/translations/{id}.json'];
    const TRANSLATION_GET_STATISTICS = ['method' => 'GET', 'path' => '/streaming/translations/{id}/statistics.json'];

    const RECORDS_GET_STATISTICS = ['method' => 'GET', 'path' => '/media/records/statistics.json'];
    const RECORD_GET_STATISTICS = ['method' => 'GET', 'path' => '/media/records/{id}/statistics.json'];
    
    const RECORD_GET_INFO = ['method' => 'GET', 'path' => '/media/records/{id}.json'];
    const RECORD_UPDATE = ['method' => 'PUT', 'path' => '/media/records/{id}.json'];
    const RECORD_DELETE = ['method' => 'DELETE', 'path' => '/media/records/{id}.json'];
    const RECORD_UPLOAD_FROM_FTP = ['method' => 'POST', 'path' => '/media/records.json'];
    const RECORD_UPLOAD_FROM_HTTP = ['method' => 'POST', 'path' => '/media/records.json'];
    const RECORD_PERMA_LINK = ['method' => 'GET', 'path' => '/media/records/{id}/watch.json'];
    const NEW_FILE_FROM_FTP = ['method' => 'POST', 'path' => '/media/records/{id}/upload.json'];
    const NEW_FILE_FROM_HTTP = ['method' => 'POST', 'path' => '/media/records/{id}/upload.json'];
    
    const FILTER_GET_RECORDS = ['method' => 'GET', 'path' => '/media/filters/{id}.json'];
    
    const ALBUM_GET = ['method' => 'GET', 'path' => '/media/albums.json'];
    const ALBUM_CREATE = ['method' => 'POST', 'path' => '/media/albums.json'];
}

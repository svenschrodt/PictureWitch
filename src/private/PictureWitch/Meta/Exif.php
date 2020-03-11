<?php  declare(strict_types = 1);
/**
 * \PictureWitch\Meta\Exif
 *
 * Class for handling EXIF meta data from images
 *
 * - converting meta data to GPS information
 *
 * @package PictureWitch
 * @author Sven Schrodt<sven@schrodt-service.net>
 * @version 0.1
 * @since 2020-03-11
 * @link https://github.com/svenschrodt/PictureWitch
 * @link https://github.com/svenschrodt/PictureWitch/blob/master/README.md
 * @copyright Sven Schrodt<sven@schrodt-service.net>
 */
namespace PictureWitch\Meta;

class Exif
{

    /**
     * 1° == 3600 seconds == 60 minutes
     * 
     */
    
    const SECONDS_IN_DEGREE = 3600;

    const SECONDS_IN_MINUTE = 60;

    /**
     * Constructor function
     *
     * @todo optional parameters
     */
    public function __construct()
    {}

    /**
     * Reading Exif meta information from image file
     *
     * @param string $file
     * @throws \ErrorException
     * @return array
     */
    public function readExifDataFromFile(string $file)
    {
        if (! file_exists($file)) {
            throw new \ErrorException('File not found: ' . $file);
        }

        $meta = exif_read_data($file);

        if (! $this->validateExifData($meta)) {
            throw new \ErrorException('Exif meta data not found');
        }

        return $meta;
    }

    /**
     * Getting long/lat from Exif geo data
     * 
     * @param array $exif
     * @return \stdClass
     */
    public function getCoordinatesFromExif(array $exif) : \stdClass
    {
        $coord = new \stdClass();
        $coord->long = $this->getGpsCoordFromExif($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
        $coord->lat = $this->getGpsCoordFromExif($exif["GPSLatitude"], $exif['GPSLatitudeRef']);

        return $coord;
    }

    
    /**
     * Get GPS coordinate from Exif geo data
     * 
     * @param array $exifCoordinate
     * @param string $hemisphere
     * @return float
     */
    public function getGpsCoordFromExif(array $exifCoordinate, string $hemisphere) : float
    {
        // Getting degree, minute and second part 
        $deg = count($exifCoordinate) > 0 ? $this->gpsToNumber($exifCoordinate[0]) : 0;
        $min = count($exifCoordinate) > 1 ? $this->gpsToNumber($exifCoordinate[1]) : 0;
        $sec = count($exifCoordinate) > 2 ? $this->gpsToNumber($exifCoordinate[2]) : 0;

        // Orientation of hemisphere
        $orientation = ($hemisphere == 'W' or $hemisphere == 'S') ? - 1 : 1;

        return $orientation * ($deg + $min / self::SECONDS_IN_MINUTE + $sec / self::SECONDS_IN_DEGREE);
    }

    /**
     * Getting coordinate from exif coordiantion part 
     * 
     * @param string $coordPart
     * @return number|mixed
     */
    public function gpsToNumber($coordPart) : float
    {
        $parts = explode('/', $coordPart);
        
        
        if (count($parts) <= 0)
            return 0;

        if (count($parts) == 1)
            return $parts[0];

        return floatval($parts[0]) / floatval($parts[1]);
    }

    /**
     * Validate exif data  
     * 
     * @param array $meta
     * @return boolean
     */
    protected function validateExifData(array $meta) : bool
    {
        // @todo check for sanity
        return true;
    }
}
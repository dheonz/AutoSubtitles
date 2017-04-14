<?php

namespace SubtitleProviders\OpenSubtitles;

class Storage
{
    /**
     * @param string $videoName
     * @return resource
     */
    public function createSubsFileByVideoName($videoName)
    {
        $subtitleBaseName = $this->getBaseName($videoName);
        $storageFolder = $this->getFolder($videoName);
        return $this->createSubtitleResource($storageFolder, $subtitleBaseName);
    }

    /**
     * @param $videoFile
     * @return string
     */
    private function getBaseName($videoFile)
    {
        return pathinfo($videoFile, PATHINFO_FILENAME);
    }

    /**
     * @param $videoFile
     * @return string
     */
    private function getFolder($videoFile)
    {
        return pathinfo($videoFile, PATHINFO_DIRNAME);
    }

    /**
     * @param string $storageFolder
     * @param string $subtitleBaseName
     * @return resource
     */
    private function createSubtitleResource($storageFolder, $subtitleBaseName)
    {
        $subsFile = $storageFolder . '/' . $subtitleBaseName . '.OpenSubtitles.srt';
        $resource = @fopen($subsFile, 'w+');
        if ($resource === false) {
            throw new \RuntimeException(sprintf('Unable to write subtitle file %s', $subsFile));
        }
        return $resource;
    }
}

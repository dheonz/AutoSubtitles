<?php

namespace SubtitleProviders;

interface SubtitleProvider
{
    /**
     * @param $videoFilename
     * @return bool
     */
    public function downloadSubtitleForVideoFile($videoFilename);
}

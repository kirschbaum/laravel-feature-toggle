<?php

namespace Kirschbaum\LaravelFeatureFlag;


use Illuminate\Support\Collection;

class FeatureFlag {

    protected $feature_id;
    protected $environment;
    protected $enabled = false;

    public function isEnabled($feature_id)
    {
        $this->setFeatureId($feature_id);
        $this->findEnvironmentSettingOrUseDefault();
        $this->takeExceptionIfNoSettingIsFound();
        return $this->getEnabled();
    }

    public function getJavascriptFlags()
    {
        $settings = new Collection(config("feature-flags"));
        $settings = $settings->where('js_export', true);

        $results = [];
        foreach($settings as $key => $setting)
        {
            $results[$key] = $this->isEnabled($key);
        }

        return $results;
    }

    private function findEnvironmentSettingOrUseDefault()
    {
        $setting = config("feature-flags.{$this->getFeatureId()}.environments.{$this->getEnvironment()}");
        if(null !== $setting)
        {
            $this->setEnabled($setting);
        } else {
            $setting = config("feature-flags.{$this->getFeatureId()}.environments.default");
            $this->setEnabled($setting);
        }
    }

    private function takeExceptionIfNoSettingIsFound()
    {
        if(null === $this->getEnabled())
            throw new \Exception(
                sprintf(
                    "FeatureFlag: Cannot find a setting for the feature ID %s",
                    $this->getFeatureId()
                )
            );
    }

    /**
     * @return mixed
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param mixed $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return mixed
     */
    public function getEnvironment()
    {
        if(null == $this->environment)
            $this->setEnvironment();

        return $this->environment;
    }

    /**
     * @param mixed $environment
     */
    public function setEnvironment($environment = null)
    {
        if(null == $environment)
            $environment = app()->environment();

        $this->environment = $environment;
    }

    /**
     * @return mixed
     */
    public function getFeatureId()
    {
        return $this->feature_id;
    }

    /**
     * @param mixed $feature_id
     */
    public function setFeatureId($feature_id)
    {
        $this->feature_id = $feature_id;
    }

}
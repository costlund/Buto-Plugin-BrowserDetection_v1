# Buto-Plugin-BrowserDetection_v1

Check browser and OS name via HTTP_USER_AGENT


## Usage

```
wfPlugin::includeonce('browser/detection_v1');
$browser = new PluginBrowserDetection_v1();
wfHelp::yml_dump($browser->get_browser());
```

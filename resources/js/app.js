import Routes from "./routes";

var Plugin = angular.module('pluginApp' , ['ngRoute']);

Plugin.config(Routes);

export default Plugin
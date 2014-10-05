function url_hook(url, not_push)
{
  if (url.indexOf('#') != -1)
    return true;

  if (!not_push)
    history.pushState({}, document.title, url);

  if (url[0] == '/')
    url = url.substring(1); 

  phoxy.MenuCall(url);
  return false; 
}

$("body").on("click", "a", function()
{
  var url = $(this).attr('href');
  
  if (url == undefined || $(this).is('[not-phoxy]'))
    return true;

  return url_hook(url, false);
});

window.onpopstate = function(e)
{
  var path = e.target.location.pathname;
  var hash = e.target.location.hash;

  if (path == '/')
    phoxy.ApiRequest(hash);
  else
    url_hook(path, true);
}

phoxy.plugin.url_hook = {MenuCall: phoxy.MenuCall};
phoxy.MenuCall = function(url)
{
  TrackPage(url);

  var args = [url, undefined];
  var callback = arguments[2];
  args[2] = function(data)
  {
    breadcrumbs.TryApply(data)
    if (typeof callback == 'function')
      callback.apply(this, args);
  }

  function DeferInit()
  {
    if (phoxy.plugin.breadcrumbs.await)
      return phoxy.Defer(args.callee, 100);

    phoxy.plugin.url_hook.MenuCall.apply(phoxy, args);
  }

  DeferInit();
}
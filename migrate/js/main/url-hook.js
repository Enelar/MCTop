function url_hook(url, not_push)
{
  if (url.indexOf('#') != -1)
    return true;
  
  if (!not_push)
    history.pushState({}, document.title, url);

  if (url[0] == '/')
    url = url.substring(1);
  
  phoxy.ApiRequest(url);
  TrackPage(url);
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
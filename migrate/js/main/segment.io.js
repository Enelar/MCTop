function TrackPage( hash )
{
  function Unify( url )
  {
    return url.replace("#!", "#");
  }

  if (typeof window.analytics != 'undefined')
    window.analytics.page({ path: Unify(hash), url: Unify(location.href) });

  // Hide google analystics after tracking complete
  if (location.search.indexOf('utm_source') != -1)
    history.pushState({}, document.title, location.pathname + location.hash);
}
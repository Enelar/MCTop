var breadcrumbs = function()
{
};

breadcrumbs.init = function()
{
  var origin = phoxy.ApiAnswer;
  phoxy.ApiAnswer = function(data)
  {
    origin.apply(this, arguments);

    if (typeof data.breadcrumbs == 'undefined')
        return;

    breadcrumbs.TryApply(arguments[0]);
  };
}

breadcrumbs.TryApply = function(data)
{
  if (typeof data.breadcrumbs == 'undefined')
    return;

  breadcrumbs.canvas.html(phoxy.DeferRender('main/utils/breadcrumbs/crumbs', {breadcrumbs: data.breadcrumbs}));
}

breadcrumbs();
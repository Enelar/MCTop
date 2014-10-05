var breadcrumbs = function()
{
};

breadcrumbs.init = function()
{
}

breadcrumbs.TryApply = function(data)
{
  if (typeof data.breadcrumbs == 'undefined')
    return;

  breadcrumbs.canvas.html(phoxy.DeferRender('main/utils/breadcrumbs/crumbs', {breadcrumbs: data.breadcrumbs}));
}

breadcrumbs();
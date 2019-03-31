{block title}{$exception->getMessage()} ({$status_code} {$status_text}){/block}

{block name=body}
    {include 'file:NaukriUtilityBundle:Exception:exception.html.tpl'}
{/block}

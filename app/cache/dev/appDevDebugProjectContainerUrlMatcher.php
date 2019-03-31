<?php

use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\RequestContext;

/**
 * This class has been auto-generated
 * by the Symfony Routing Component.
 */
class appDevDebugProjectContainerUrlMatcher extends Symfony\Bundle\FrameworkBundle\Routing\RedirectableUrlMatcher
{
    public function __construct(RequestContext $context)
    {
        $this->context = $context;
    }

    public function match($pathinfo)
    {
        $allow = array();
        $pathinfo = rawurldecode($pathinfo);
        $context = $this->context;
        $request = $this->request;

        if (0 === strpos($pathinfo, '/_')) {
            // _wdt
            if (0 === strpos($pathinfo, '/_wdt') && preg_match('#^/_wdt/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                return $this->mergeDefaults(array_replace($matches, array('_route' => '_wdt')), array (  '_controller' => 'web_profiler.controller.profiler:toolbarAction',));
            }

            if (0 === strpos($pathinfo, '/_profiler')) {
                // _profiler_home
                if ('/_profiler' === rtrim($pathinfo, '/')) {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_profiler_home');
                    }

                    return array (  '_controller' => 'web_profiler.controller.profiler:homeAction',  '_route' => '_profiler_home',);
                }

                if (0 === strpos($pathinfo, '/_profiler/search')) {
                    // _profiler_search
                    if ('/_profiler/search' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchAction',  '_route' => '_profiler_search',);
                    }

                    // _profiler_search_bar
                    if ('/_profiler/search_bar' === $pathinfo) {
                        return array (  '_controller' => 'web_profiler.controller.profiler:searchBarAction',  '_route' => '_profiler_search_bar',);
                    }

                }

                // _profiler_purge
                if ('/_profiler/purge' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:purgeAction',  '_route' => '_profiler_purge',);
                }

                // _profiler_info
                if (0 === strpos($pathinfo, '/_profiler/info') && preg_match('#^/_profiler/info/(?P<about>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_info')), array (  '_controller' => 'web_profiler.controller.profiler:infoAction',));
                }

                // _profiler_phpinfo
                if ('/_profiler/phpinfo' === $pathinfo) {
                    return array (  '_controller' => 'web_profiler.controller.profiler:phpinfoAction',  '_route' => '_profiler_phpinfo',);
                }

                // _profiler_search_results
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/search/results$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_search_results')), array (  '_controller' => 'web_profiler.controller.profiler:searchResultsAction',));
                }

                // _profiler
                if (preg_match('#^/_profiler/(?P<token>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler')), array (  '_controller' => 'web_profiler.controller.profiler:panelAction',));
                }

                // _profiler_router
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/router$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_router')), array (  '_controller' => 'web_profiler.controller.router:panelAction',));
                }

                // _profiler_exception
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception')), array (  '_controller' => 'web_profiler.controller.exception:showAction',));
                }

                // _profiler_exception_css
                if (preg_match('#^/_profiler/(?P<token>[^/]++)/exception\\.css$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_profiler_exception_css')), array (  '_controller' => 'web_profiler.controller.exception:cssAction',));
                }

            }

            if (0 === strpos($pathinfo, '/_configurator')) {
                // _configurator_home
                if ('/_configurator' === rtrim($pathinfo, '/')) {
                    if (substr($pathinfo, -1) !== '/') {
                        return $this->redirect($pathinfo.'/', '_configurator_home');
                    }

                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::checkAction',  '_route' => '_configurator_home',);
                }

                // _configurator_step
                if (0 === strpos($pathinfo, '/_configurator/step') && preg_match('#^/_configurator/step/(?P<index>[^/]++)$#s', $pathinfo, $matches)) {
                    return $this->mergeDefaults(array_replace($matches, array('_route' => '_configurator_step')), array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::stepAction',));
                }

                // _configurator_final
                if ('/_configurator/final' === $pathinfo) {
                    return array (  '_controller' => 'Sensio\\Bundle\\DistributionBundle\\Controller\\ConfiguratorController::finalAction',  '_route' => '_configurator_final',);
                }

            }

        }

        if (0 === strpos($pathinfo, '/gnb')) {
            if (0 === strpos($pathinfo, '/gnbRoute/gnb')) {
                // components_gnb_nl
                if ('/gnbRoute/gnb/nl' === $pathinfo) {
                    return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\GnbController::RecruiterNotLoggedInGnbAction',  '_route' => 'components_gnb_nl',);
                }

                // components_gnb_lg
                if ('/gnbRoute/gnb/lg' === $pathinfo) {
                    return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\GnbController::RecruiterLoggedInGnbAction',  '_route' => 'components_gnb_lg',);
                }

            }

            // components_gnb_footer_lg
            if ('/gnbFooter/gnb/lg' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\GnbController::RecruiterLoggedInGnbFooterAction',  '_route' => 'components_gnb_footer_lg',);
            }

            // components_gnb_csm
            if ('/gnbRoute/gnb/csm' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\GnbController::RecruiterLoggedInGnbCsmAction',  '_route' => 'components_gnb_csm',);
            }

        }

        if (0 === strpos($pathinfo, '/recruiterGnb')) {
            // components_tnr_add_task
            if ('/recruiterGnb/addTask' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::addTaskAction',  '_route' => 'components_tnr_add_task',);
            }

            // components_tnr_get_tasks
            if ('/recruiterGnb/getTask' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::getTaskAction',  '_route' => 'components_tnr_get_tasks',);
            }

            // components_tnr_edit_task
            if ('/recruiterGnb/editTask' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::editTaskAction',  '_route' => 'components_tnr_edit_task',);
            }

            // components_tnr_delete_task
            if ('/recruiterGnb/updateTaskStatus' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::updateTaskStatusAction',  '_route' => 'components_tnr_delete_task',);
            }

            // components_tnr_get_notifications
            if ('/recruiterGnb/getAllNotifications' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::getAllNotificationsAction',  '_route' => 'components_tnr_get_notifications',);
            }

            // components_tnr_read_notifications
            if ('/recruiterGnb/markAllNotificationsAsRead' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::markAllNotificationsAsReadAction',  '_route' => 'components_tnr_read_notifications',);
            }

            if (0 === strpos($pathinfo, '/recruiterGnb/get')) {
                // components_gnb_tags
                if ('/recruiterGnb/getTags' === $pathinfo) {
                    return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::getTagsAction',  '_route' => 'components_gnb_tags',);
                }

                // components_gnb_mentions
                if ('/recruiterGnb/getMentions' === $pathinfo) {
                    return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::getMentionsAction',  '_route' => 'components_gnb_mentions',);
                }

            }

            // components_tnr_track_invite_mail
            if ('/recruiterGnb/trackInviteMail' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::trackInviteMailAction',  '_route' => 'components_tnr_track_invite_mail',);
            }

            // components_tnr_update_reminder_status
            if ('/recruiterGnb/updateReminderStatus' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::updateReminderStatusAction',  '_route' => 'components_tnr_update_reminder_status',);
            }

            // components_gnb_recruiter_chat
            if ('/recruiterGnb/getChatJobs' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\ComponentBundle\\Controller\\TaskReminderController::getChatJobsAction',  '_route' => 'components_gnb_recruiter_chat',);
            }

        }

        if (0 === strpos($pathinfo, '/a')) {
            if (0 === strpos($pathinfo, '/accounts')) {
                if (0 === strpos($pathinfo, '/accounts/user')) {
                    // create_user
                    if ('/accounts/user' === $pathinfo) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_create_user;
                        }

                        return array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::createUser',  '_route' => 'create_user',);
                    }
                    not_create_user:

                    // delete_user
                    if (preg_match('#^/accounts/user/(?P<id>.*)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_user;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_user')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::deleteUser',));
                    }
                    not_delete_user:

                }

                if (0 === strpos($pathinfo, '/accounts/group')) {
                    // create_group
                    if ('/accounts/group' === $pathinfo) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_create_group;
                        }

                        return array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::createGroup',  '_route' => 'create_group',);
                    }
                    not_create_group:

                    // delete_group
                    if (preg_match('#^/accounts/group/(?P<id>.*)$#s', $pathinfo, $matches)) {
                        if ($this->context->getMethod() != 'DELETE') {
                            $allow[] = 'DELETE';
                            goto not_delete_group;
                        }

                        return $this->mergeDefaults(array_replace($matches, array('_route' => 'delete_group')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::deleteGroup',));
                    }
                    not_delete_group:

                }

                if (0 === strpos($pathinfo, '/accounts/user')) {
                    // assign_user_to_group
                    if ('/accounts/user/assign' === $pathinfo) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_assign_user_to_group;
                        }

                        return array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::assignGroupToUser',  '_route' => 'assign_user_to_group',);
                    }
                    not_assign_user_to_group:

                    // remove_user_from_group
                    if ('/accounts/user/remove' === $pathinfo) {
                        if ($this->context->getMethod() != 'POST') {
                            $allow[] = 'POST';
                            goto not_remove_user_from_group;
                        }

                        return array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AccountsController::removeGroupFromUser',  '_route' => 'remove_user_from_group',);
                    }
                    not_remove_user_from_group:

                }

            }

            // admin_manage
            if ('/admin/manage' === $pathinfo) {
                return array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\AdminController::loadAdminModule',  '_route' => 'admin_manage',);
            }

        }

        if (0 === strpos($pathinfo, '/resource/report')) {
            // ore_jp_reports_get_request
            if (preg_match('#^/resource/report/(?P<url>.+)$#s', $pathinfo, $matches)) {
                if (!in_array($this->context->getMethod(), array('GET', 'HEAD'))) {
                    $allow = array_merge($allow, array('GET', 'HEAD'));
                    goto not_ore_jp_reports_get_request;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ore_jp_reports_get_request')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\JobReportsController::handleJobGetRequest',));
            }
            not_ore_jp_reports_get_request:

            // ore_jp_reports_post_request
            if (preg_match('#^/resource/report/(?P<url>.+)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'POST') {
                    $allow[] = 'POST';
                    goto not_ore_jp_reports_post_request;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ore_jp_reports_post_request')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\JobReportsController::handleJobPostRequest',));
            }
            not_ore_jp_reports_post_request:

            // ore_jp_reports_delete_request
            if (preg_match('#^/resource/report/(?P<url>.+)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'DELETE') {
                    $allow[] = 'DELETE';
                    goto not_ore_jp_reports_delete_request;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ore_jp_reports_delete_request')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\JobReportsController::handleJobDeleteRequest',));
            }
            not_ore_jp_reports_delete_request:

            // ore_jp_reports_put_request
            if (preg_match('#^/resource/report/(?P<url>.+)$#s', $pathinfo, $matches)) {
                if ($this->context->getMethod() != 'PUT') {
                    $allow[] = 'PUT';
                    goto not_ore_jp_reports_put_request;
                }

                return $this->mergeDefaults(array_replace($matches, array('_route' => 'ore_jp_reports_put_request')), array (  '_controller' => 'Naukri\\JobPostingGatewayBundle\\Controller\\JobReportsController::handleJobPutRequest',));
            }
            not_ore_jp_reports_put_request:

        }

        throw 0 < count($allow) ? new MethodNotAllowedException(array_unique($allow)) : new ResourceNotFoundException();
    }
}

<?php
echo "";
?>
<script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
<script type="text/javascript">
    window.OneSignalDeferred = window.OneSignalDeferred || [];
    OneSignalDeferred.push(function(OneSignal) {
        OneSignal.init({
            appId: "ee653b16-ca97-4751-881b-c2bb9c225328",
            safari_web_id: "web.onesignal.auto.4d177f4c-af32-40a6-bcd9-e75371e6c146",
            autoRegister: true,
            notifyButton: {
                enable: false, /* Required to use the notify button */
                size: 'medium', /* One of 'small', 'medium', or 'large' */
                theme: 'default', /* One of 'default' (red-white) or 'inverse" (white-red) */
                position: 'bottom-right', /* Either 'bottom-left' or 'bottom-right' */
                prenotify: true, /* Show an icon with 1 unread message for first-time site visitors */
                showCredit: false, /* Hide the OneSignal logo */
                text: {
                    'tip.state.unsubscribed': 'Subscribe to notifications',
                    'tip.state.subscribed': "You're subscribed to notifications",
                    'tip.state.blocked': "You've blocked notifications",
                    'message.prenotify': 'Click to subscribe to notifications',
                    'message.action.subscribed': "Thanks for subscribing!",
                    'message.action.resubscribed': "You're subscribed to notifications",
                    'message.action.unsubscribed': "You won't receive notifications again",
                    'dialog.main.title': 'Mah Sing Maintenance App Notifications',
                    'dialog.main.button.subscribe': 'SUBSCRIBE',
                    'dialog.main.button.unsubscribe': 'UNSUBSCRIBE',
                    'dialog.blocked.title': 'Unblock Notifications',
                    'dialog.blocked.message': "Follow these instructions to allow notifications:"
                }
            }
        });

        OneSignal.User.addTag("uacc_id", "<?php echo $logged_in['uacc_id'] ?>");

    });

    /*
    OneSignal.push(["sendTags", {
        uacc_id: "<?php echo $logged_in['uacc_id'] ?>",
            uacc_username: "<?php echo $logged_in['uacc_username'] ?>",
            role: "<?php echo $logged_in['uacc_group_fk'] ?>",
            pushnotification: "yes"
        }]);
        */
</script>
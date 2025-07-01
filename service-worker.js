



const staticDevCoffee = 'NEX App';

const assets = [

    '/',

    '/pwa_offline_landing.html',

];

let deferredPrompt;

self.addEventListener('install', installEvent => {

    installEvent.waitUntil(

        caches.open(staticDevCoffee).then(cache => {

            //cache.addAll(assets);

        })

    );

});



self.addEventListener('fetch', fetchEvent => {

    fetchEvent.respondWith(

        caches.match(fetchEvent.request).then(res=>{

            return res || fetch(fetchEvent.request)

        })

    )

});



self.addEventListener('online', handleConnection);

self.addEventListener('offline', handleConnection);



function handleConnection() {

    if (navigator.onLine) {

        isReachable(getServerUrl()).then(function(online) {

            if (online) {

                // handle online status

                console.log('online');

            } else {

                console.log('no connectivity');

            }

        });

    } else {

        // handle offline status

        console.log('offline');

    }

}



function isReachable(url) {

    /**

     * Note: fetch() still "succeeds" for 404s on subdirectories,

     * which is ok when only testing for domain reachability.

     *

     * Example:

     *   https://google.com/noexist does not throw

     *   https://noexist.com/noexist does throw

     */

    return fetch(url, { method: 'HEAD', mode: 'no-cors' })

        .then(function(resp) {

            alert("Connection OK");

            return resp && (resp.ok || resp.type === 'opaque');

        })

        .catch(function(err) {

            alert("Connection ERROR");

            console.warn('[conn test failure]:', err);

        });

}



function getServerUrl() {

    var url = "https://staging.dsnt.com.my/";

    return url;

}
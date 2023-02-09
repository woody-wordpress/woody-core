const cacheName = 'sw_woody_1.0.2';
const contentToCache = [
    // e.g  '/src/assets/apis/Booking.png',
];;

// add new asset to cache when Sw is intall
self.addEventListener('install', (e) => {
    e.waitUntil(
        (async () => {
        const cache = await caches.open(cacheName);
        await cache.addAll(contentToCache);
        if (cacheName.includes('--force')) {
            self.skipWaiting();
        }
        })(),
    );
});

// check if request is cache then response with cache if possible
self.addEventListener('fetch', (e) => {
    e.respondWith(
        (async () => {

            const response = await fetch(e.request);
            return response;
        })(),
    );
});

// When activate clear old cache
self.addEventListener('activate', (e) => {
    e.waitUntil(
        caches.keys().then((keyList) => {
        return Promise.all(
            keyList.map((key) => {
            if (key === cacheName) {
                return;
            }
            return caches.delete(key);
            }),
        );
        }),
    );
});

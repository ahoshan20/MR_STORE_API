import React, { useEffect } from 'react';
import { Html5QrcodeScanner } from 'html5-qrcode';
import { router } from '@inertiajs/react';

const QRScanner = () => {
    useEffect(() => {
        const scanner = new Html5QrcodeScanner(
            'reader',
            {
                fps: 10,
                qrbox: { width: 250, height: 250 },
            },
            false // verbose (optional)
        );

        scanner.render(onScanSuccess, onScanError);

        function onScanSuccess(decodedText) {
            // Stop scanning after successful scan (important!)
            scanner.clear();

            router.post('/scan-product', { 
                barcode: decodedText 
            }, {
                onSuccess: () => {
                    alert("Data saved successfully!");
                },
                onError: (errors) => {
                    console.error("Database save failed", errors);
                }
            });
        }

        function onScanError(err) {
            // Ignore frequent scan errors
            // console.warn(err);
        }

        return () => {
            scanner.clear().catch(error => {
                console.warn("Failed to clear scanner", error);
            });
        };
    }, []);

    return (
        <div className="p-5">
            <h2 className="mb-4 text-xl font-bold">Scan QR or Barcode</h2>
            <div id="reader" style={{ width: '100%', maxWidth: '500px' }}></div>
        </div>
    );
};

export default QRScanner;
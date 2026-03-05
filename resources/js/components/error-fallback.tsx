import React from 'react';

export default function ErrorFallback({ error, resetErrorBoundary }: any) {
    return (
        <div className="min-h-screen flex items-center justify-center bg-gray-700 px-4">
            <div className="bg-white/20 rounded-lg shadow-lg p-8 max-w-md w-full text-center">
                <h2 className="text-2xl font-bold text-red-900 mb-4">Oops! Something went wrong</h2>
                <p className="text-gray-300 mb-4">An unexpected error occurred. Please try again.</p>
                <pre className="text-sm text-gray-200 bg-gray-600 p-4 rounded mb-6 overflow-auto">
                    {String(error)}
                </pre>
                <button
                    onClick={resetErrorBoundary}
                    className="bg-red-900 hover:bg-red-800 text-white font-semibold py-2 px-6 rounded transition-colors duration-200"
                >
                    Reload
                </button>
            </div>
        </div>
    );
}

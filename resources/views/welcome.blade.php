<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>vCommerce - Ecommerce API</title>
    <!-- Tailwind CSS for styling -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Hero Section -->
    <div class="relative overflow-hidden min-h-screen flex flex-col justify-between">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-96 bg-gradient-to-r from-emerald-500/10 to-blue-500/10 blur-3xl rounded-full pointer-events-none"></div>

        <!-- Header -->
        <header class="container mx-auto px-6 py-6 flex justify-between items-center relative z-10">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-tr from-emerald-400 to-teal-600 p-2.5 rounded-xl shadow-lg shadow-emerald-500/20">
                    <i class="fas fa-shopping-bag text-xl text-white"></i>
                </div>
                <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-white to-slate-400 bg-clip-text text-transparent">vCommerce <span class="text-emerald-400 text-sm font-medium">API</span></span>
            </div>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    API Status: Live
                </span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-12 flex-grow flex flex-col lg:flex-row items-center justify-center gap-12 relative z-10">
            <div class="max-w-2xl text-center lg:text-left space-y-6">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-none text-white">
                    The Backbone of Your <br>
                    <span class="bg-gradient-to-r from-emerald-400 via-teal-400 to-blue-500 bg-clip-text text-transparent">Next-Gen Ecommerce</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-xl mx-auto lg:mx-0">
                    A robust, secure, and lightning-fast RESTful API built with Laravel. Seamlessly manage products, authentication, carts, and orders.
                </p>
                <div class="pt-4 flex flex-wrap gap-4 justify-center lg:justify-start">
                    <a href="/api/v1/products" target="_blank" class="px-6 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-400 hover:to-teal-500 text-white font-medium shadow-lg shadow-emerald-900/30 transition-all duration-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <i class="fas fa-external-link-alt text-sm"></i> Test Products API
                    </a>
                    <a href="#endpoints" class="px-6 py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-medium border border-slate-700/50 transition-all duration-200 flex items-center gap-2">
                        <i class="fas fa-code text-sm"></i> View Endpoints
                    </a>
                </div>
            </div>

            <!-- Visual Code Block Card -->
            <div class="w-full max-w-md bg-slate-950/80 backdrop-blur-md rounded-2xl border border-slate-800 p-6 shadow-2xl relative">
                <div class="flex items-center justify-between pb-4 border-b border-slate-800 mb-4">
                    <div class="flex space-x-2">
                        <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
                        <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
                    </div>
                    <span class="text-xs text-slate-500 font-mono">GET /api/v1/products</span>
                </div>
                <pre class="text-xs sm:text-sm font-mono text-emerald-400 overflow-x-auto"><code>{
  <span class="text-blue-400">"status"</span>: <span class="text-amber-400">"success"</span>,
  <span class="text-blue-400">"data"</span>: [
    {
      <span class="text-blue-400">"id"</span>: 1,
      <span class="text-blue-400">"name"</span>: <span class="text-amber-400">"Wireless Earbuds"</span>,
      <span class="text-blue-400">"price"</span>: 49.99,
      <span class="text-blue-400">"stock"</span>: <span class="text-indigo-400">120</span>
    }
  ]
}</code></pre>
            </div>
        </main>

        <!-- API Endpoints Quick Reference -->
        <section id="endpoints" class="container mx-auto px-6 py-12 relative z-10">
            <div class="bg-slate-950/40 border border-slate-800/60 rounded-2xl p-6">
                <h3 class="text-sm font-semibold tracking-wider uppercase text-slate-400 mb-4 flex items-center gap-2">
                    <i class="fas fa-network-wired text-emerald-400"></i> Core API Endpoints
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/50 flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold text-blue-400 mr-2 bg-blue-500/10 px-2 py-0.5 rounded">POST</span>
                            <span class="font-mono text-sm text-slate-300">/api/admin/login</span>
                        </div>
                        <span class="text-xs text-slate-500">Auth</span>
                    </div>
                    <div class="bg-slate-900/60 p-4 rounded-xl border border-slate-800/50 flex justify-between items-center">
                        <div>
                            <span class="text-xs font-bold text-emerald-400 mr-2 bg-emerald-500/10 px-2 py-0.5 rounded">GET</span>
                            <span class="font-mono text-sm text-slate-300">/api/v1/products</span>
                        </div>
                        <span class="text-xs text-slate-500">Store</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="border-t border-slate-800/50 py-6 text-center text-xs text-slate-500 relative z-10">
            <p>&copy; {{ date('Y') }} vCommerce API. All APIs operational.</p>
        </footer>
    </div>

</body>
</html>
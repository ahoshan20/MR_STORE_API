import React from 'react';
import { Head, Link } from '@inertiajs/react';
// import { route } from '@inertiajs/react';
import { 
  CheckCircle, 
  BarChart3, 
  Zap, 
  ShieldCheck, 
  ArrowRight 
} from 'lucide-react';
import DashboardDataTable from '../components/ui/datatable';

interface Props {
  canLogin: boolean;
  canRegister: boolean;
  laravelVersion: string;
  phpVersion: string;
}

export default function Welcome({ canLogin, canRegister }: Props) {
  return (
    <div className="min-h-screen bg-slate-50 font-sans text-slate-900">
      <Head title="Modern POS Solution" />

      {/* --- Navigation --- */}
      <nav className="flex items-center justify-between px-8 py-6 bg-white border-b border-slate-200 sticky top-0 z-50">
        <div className="flex items-center gap-2">
          <div className="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
            P
          </div>
          <span className="text-xl font-bold tracking-tight">SwiftPOS</span>
        </div>
        
        <div className="space-x-6 flex items-center">
          <a href="#features" className="text-slate-600 hover:text-indigo-600 font-medium">Features</a>
          <a href="#pricing" className="text-slate-600 hover:text-indigo-600 font-medium">Pricing</a>
          
          {canLogin && (
            <Link
              href='/login'
              className="px-5 py-2 text-indigo-600 font-semibold hover:bg-indigo-50 rounded-lg transition"
            >
              Log in
            </Link>
          )}
          
          {canRegister && (
            <Link
              href='/register'
              className="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-lg shadow-md hover:bg-indigo-700 transition"
            >
              Get Started
            </Link>
          )}
        </div>
      </nav>

      {/* --- Hero Section --- */}
      <header className="px-8 py-20 lg:py-32 max-w-7xl mx-auto text-center">
        <h1 className="text-5xl lg:text-7xl font-extrabold tracking-tight mb-6">
          The POS that <span className="text-indigo-600">scales</span> with you.
        </h1>
        <p className="text-xl text-slate-600 max-w-2xl mx-auto mb-10">
          Manage inventory, track real-time sales, and empower your staff with a lightning-fast interface designed for modern retail.
        </p>
        <div className="flex flex-col sm:flex-row justify-center gap-4">
          <button className="px-8 py-4 bg-slate-900 text-white rounded-xl font-bold text-lg flex items-center justify-center gap-2 hover:bg-slate-800">
            Book a Demo <ArrowRight size={20} />
          </button>
          <button className="px-8 py-4 bg-white border border-slate-200 rounded-xl font-bold text-lg hover:border-indigo-400 transition">
            View Pricing
          </button>
        </div>
      </header>

      <DashboardDataTable />

      {/* --- Features Grid --- */}
      <section id="features" className="bg-white py-24 px-8 border-y border-slate-200">
        <div className="max-w-7xl mx-auto grid md:grid-cols-3 gap-12">
          <FeatureCard 
            icon={<Zap className="text-yellow-500" />}
            title="Instant Transactions"
            desc="Offline-first capabilities ensure your registers never stop, even if the internet does."
          />
          <FeatureCard 
            icon={<BarChart3 className="text-indigo-600" />}
            title="Deep Analytics"
            desc="Automated end-of-day reports and real-time inventory tracking at your fingertips."
          />
          <FeatureCard 
            icon={<ShieldCheck className="text-green-500" />}
            title="Secure & Reliable"
            desc="Enterprise-grade encryption and automated cloud backups for your peace of mind."
          />
        </div>
      </section>

      {/* --- Social Proof --- */}
      <footer className="py-20 text-center">
        <p className="text-slate-400 uppercase tracking-widest text-sm font-bold mb-8">Trusted by 500+ businesses</p>
        <div className="flex flex-wrap justify-center gap-12 opacity-50 grayscale">
            {/* Replace with actual partner logos */}
            <span className="text-2xl font-black italic text-slate-400">COFFEEHOUSE</span>
            <span className="text-2xl font-black italic text-slate-400">RETAIL.CO</span>
            <span className="text-2xl font-black italic text-slate-400">BISTRO.IO</span>
        </div>
      </footer>
    </div>
  );
}

function FeatureCard({ icon, title, desc }: { icon: React.ReactNode, title: string, desc: string }) {
  return (
    <div className="p-8 rounded-2xl hover:shadow-xl transition-shadow border border-transparent hover:border-slate-100">
      <div className="mb-4">{icon}</div>
      <h3 className="text-xl font-bold mb-2">{title}</h3>
      <p className="text-slate-600 leading-relaxed">{desc}</p>
    </div>
  );
}
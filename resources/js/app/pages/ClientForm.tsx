import { useState } from 'react';
import { useNavigate } from 'react-router-dom';
import { useApp } from '../context/AppContext';
import { ArrowLeft, Save } from 'lucide-react';
import { Client } from '../data/types';
import { toast } from 'sonner';

export default function ClientForm() {
  const navigate = useNavigate();
  const { clients, addClient } = useApp();

  const [formData, setFormData] = useState({
    name: '',
    companyName: '',
    cpfCnpj: '',
    email: '',
    phone: '',
    logradouro: '',
    numero: '',
    complemento: '',
    cep: '',
    bairro: '',
    cidade: '',
    estado: '',
  });

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();

    const newClient: Client = {
      id: String(clients.length + 1),
      ...formData,
    };

    addClient(newClient);
    toast.success('Client created successfully!');
    navigate(`/clients/${newClient.id}`);
  };

  return (
    <div className="p-8 space-y-6">
      <div className="flex items-center gap-4">
        <button
          onClick={() => navigate('/clients')}
          className="p-2 hover:bg-slate-100 rounded-lg transition-colors"
        >
          <ArrowLeft className="w-5 h-5" />
        </button>
        <h1 className="text-3xl">New Client</h1>
      </div>

      <form onSubmit={handleSubmit} className="bg-white p-8 rounded-lg border border-slate-200 shadow-sm space-y-8">
        <div>
          <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Personal Information</h2>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="block text-sm mb-2">
                Name <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.name}
                onChange={e => setFormData({ ...formData, name: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Company Name <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.companyName}
                onChange={e => setFormData({ ...formData, companyName: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                CPF/CNPJ <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.cpfCnpj}
                onChange={e => setFormData({ ...formData, cpfCnpj: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="00.000.000/0001-00"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Email <span className="text-red-500">*</span>
              </label>
              <input
                type="email"
                required
                value={formData.email}
                onChange={e => setFormData({ ...formData, email: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Phone <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.phone}
                onChange={e => setFormData({ ...formData, phone: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="(00) 00000-0000"
              />
            </div>
          </div>
        </div>

        <div>
          <h2 className="text-lg mb-4 pb-2 border-b border-slate-200">Address</h2>
          <div className="grid grid-cols-2 gap-4">
            <div className="col-span-2">
              <label className="block text-sm mb-2">
                Logradouro <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.logradouro}
                onChange={e => setFormData({ ...formData, logradouro: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Número <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.numero}
                onChange={e => setFormData({ ...formData, numero: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">Complemento</label>
              <input
                type="text"
                value={formData.complemento}
                onChange={e => setFormData({ ...formData, complemento: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                CEP <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.cep}
                onChange={e => setFormData({ ...formData, cep: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="00000-000"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Bairro <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.bairro}
                onChange={e => setFormData({ ...formData, bairro: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Cidade <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.cidade}
                onChange={e => setFormData({ ...formData, cidade: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
              />
            </div>
            <div>
              <label className="block text-sm mb-2">
                Estado <span className="text-red-500">*</span>
              </label>
              <input
                type="text"
                required
                value={formData.estado}
                onChange={e => setFormData({ ...formData, estado: e.target.value })}
                className="w-full px-4 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                placeholder="SP"
                maxLength={2}
              />
            </div>
          </div>
        </div>

        <div className="flex items-center gap-4 pt-4 border-t border-slate-200">
          <button
            type="submit"
            className="flex items-center gap-2 px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors"
          >
            <Save className="w-5 h-5" />
            Create Client
          </button>
          <button
            type="button"
            onClick={() => navigate('/clients')}
            className="px-6 py-2 border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors"
          >
            Cancel
          </button>
        </div>
      </form>
    </div>
  );
}

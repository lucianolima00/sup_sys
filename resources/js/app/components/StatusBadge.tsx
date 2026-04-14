import { TicketStatus } from '../data/types';

interface StatusBadgeProps {
  status: TicketStatus;
  className?: string;
}

export default function StatusBadge({ status, className = '' }: StatusBadgeProps) {
  const statusConfig = {
    open: { label: 'Open', color: 'bg-slate-100 text-slate-700 border-slate-300' },
    in_progress: { label: 'In Progress', color: 'bg-amber-100 text-amber-700 border-amber-300' },
    awaiting_client: { label: 'Awaiting Client', color: 'bg-blue-100 text-blue-700 border-blue-300' },
    resolved: { label: 'Resolved', color: 'bg-emerald-100 text-emerald-700 border-emerald-300' },
    closed: { label: 'Closed', color: 'bg-gray-100 text-gray-700 border-gray-300' },
    cancelled: { label: 'Cancelled', color: 'bg-red-100 text-red-700 border-red-300' },
  };

  const config = statusConfig[status];

  return (
    <span className={`inline-flex items-center px-2.5 py-0.5 rounded-md text-xs border ${config.color} ${className}`}>
      {config.label}
    </span>
  );
}

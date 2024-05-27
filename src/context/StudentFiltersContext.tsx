import React, { createContext, useState, ReactNode, useMemo, useCallback } from 'react';

interface StudentFiltersContextType {
  selectedRoles: string[];
  addRole: (role: string) => void;
  removeRole: (role: string) => void;
}

export const StudentFiltersContext = createContext<StudentFiltersContextType | undefined>(undefined);

interface StudentFiltersProviderProps {
  children: ReactNode;
}

export const StudentFiltersProvider: React.FC<StudentFiltersProviderProps> = ({ children }) => {
  const [selectedRoles, setSelectedRoles] = useState<string[]>([]);

  const addRole = useCallback((role: string) => {
    setSelectedRoles(prevRoles => [...prevRoles, role]);
  }, []);

  const removeRole = useCallback((role: string) => {
    setSelectedRoles(prevRoles => prevRoles.filter(r => r !== role));
  }, []);

  const value = useMemo(() => ({ selectedRoles, addRole, removeRole }), [selectedRoles, addRole, removeRole]);

  return (
    <StudentFiltersContext.Provider value={value}>
      {children}
    </StudentFiltersContext.Provider>
  );
};
import React, { createContext, useState, useEffect, ReactNode, useContext } from 'react';
import { useStudentIdContext } from './StudentIdContext';

interface SocialMedia {
  github: { url: string };
  linkedin: { url: string };
}

interface StudentData {
  fullname: string;
  subtitle: string;
  social_media: SocialMedia;
  about: string;
  tags: { id: number; name: string }[];
}

interface StudentContextProps {
  studentData: StudentData | null;
}

const StudentContext = createContext<StudentContextProps>({ studentData: null });

const StudentProvider: React.FC<{ children: ReactNode }> = ({ children }) => {
  const { studentUUID } = useStudentIdContext();
  const [studentData, setStudentData] = useState<StudentData | null>(null);

  useEffect(() => {
    if (studentUUID) {
      fetch(`https://itaperfils.eurecatacademy.org/student/${studentUUID}/resume/detail`)
        .then(response => {
          if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
          }
          return response.json();
        })
        .then(data => setStudentData(data.data[0]))
        .catch(error => console.error('Error fetching student data:', error));
    }
  }, [studentUUID]);

  return (
    <StudentContext.Provider value={{ studentData }}>
      {children}
    </StudentContext.Provider>
  );
};

export { StudentContext, StudentProvider };

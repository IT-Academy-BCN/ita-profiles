import React from 'react';

const items = [
  { text: 'Nombre, título, gitHub y Linkedin', checked: true },
  { text: 'Presentación', checked: true },
  { text: 'Skills', checked: true },
  { text: 'Proyectos', checked: true },
  { text: 'Colaboración', checked: true },
  { text: 'Formación', checked: true },
  { text: 'Idiomas', checked: false },
  { text: 'Modalidad de empleo', checked: false },
];

const CompletedSteps = () => (
    <ul>
      {items.map((item) => (
        <li  style={{ color: item.checked ? 'magenta' : 'gray' }}>
          {item.text}
        </li>
      ))}
    </ul>
  );

export default CompletedSteps;
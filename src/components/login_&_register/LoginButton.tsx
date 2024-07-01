import React from 'react'

const LoginButton: React.FC<{ onClick: () => void }> = ({ onClick }) => (
  <div className="flex">
    <button
      type="button"
      className="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4"
      onClick={onClick}
    >
      Entrar
    </button>
  </div>
)

export default LoginButton

import React, { useState } from 'react'
import { Lock } from '../../assets/svg'
import RegisterPopup from './RegisterPopup'

type ModalProps = {
  onClose: () => void
}
const RestrictedAccessPopup: React.FC<ModalProps> = ({ onClose }) => {
  const [showRegisterPopup, setShowRegisterPopup] = useState(false)

  const handleOpenRegisterPopup = () => {
    setShowRegisterPopup(true)
    /*  onClose(); */
  }

  const handleCloseRegisterPopup = () => {
    setShowRegisterPopup(false)
  }

  return (
    <div
      style={{
        position: 'fixed',
        top: 0,
        left: 0,
        width: '100%',
        height: '100%',
        backgroundColor: 'rgba(0, 0, 0, 0.5)',
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
        zIndex: 9999,
      }}
    >
      <div
        style={{
          width: '300px',
          borderRadius: '12px',
          backgroundColor: 'white',
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
          padding: '20px',
          position: 'relative',
        }}
      >
        <button
          type="button"
          style={{
            position: 'absolute',
            top: '10px',
            right: '10px',
            width: '30px',
            height: '30px',
            borderRadius: '50%',
            backgroundColor: 'transparent',
            border: 'none',
            cursor: 'pointer',
          }}
          onClick={onClose}
        >
          ✕
        </button>
        <img
          src={Lock}
          alt="Lock"
          style={{
            width: '118px',
            height: '118px',
            marginBottom: '20px',
          }}
        />
        <h2 style={{ fontSize: '24px', marginBottom: '10px' }}>
          Acceso restringido
        </h2>
        <p style={{ fontSize: '18px', marginBottom: '30px' }}>
          Entra o regístrate para acceder al perfil
        </p>
        <div>
          <button
            type="button"
            style={{
              width: '100%',
              height: '63px',
              borderRadius: '12px',
              backgroundColor: '#B91879',
              color: 'white',
              fontSize: '18px',
              marginBottom: '10px',
            }}
            onClick={handleOpenRegisterPopup}
          >
            Soy candidato/a
          </button>
          <button
            type="button"
            style={{
              width: '100%',
              height: '63px',
              borderRadius: '12px',
              backgroundColor: '#B91879',
              color: 'white',
              fontSize: '18px',
            }}
            onClick={onClose}
          >
            Soy reclutador/a
          </button>
        </div>
      </div>
      {showRegisterPopup && (
        <RegisterPopup
          onClose={handleCloseRegisterPopup}
          onOpenLoginPopup={handleOpenRegisterPopup}
        />
      )}
    </div>
  )
}

export default RestrictedAccessPopup

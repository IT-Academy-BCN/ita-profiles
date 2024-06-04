import axios from 'axios'
import { useEffect, useState } from 'react'

type TermsPopUpProps = {
    handleTermsPopup: () => void
}

const TermsPopUp: React.FC<TermsPopUpProps> = ({ handleTermsPopup }) => {
    const [termsAndConditions, setTermsAndConditions] = useState('')
    const [error, setError] = useState('')
    console.log('termsAndConditions -->', termsAndConditions)

    const endpointTermsandConditions = `//localhost:8000/api/v1/terms-and-conditions`

    useEffect(() => {
        axios
            .get(endpointTermsandConditions, {
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then((response) => {
                setTermsAndConditions(response.data)
            })
            .catch((err) => {
                setError(err.message)
            })
    }, [endpointTermsandConditions])

    return (
        <div className=" absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full z-10 bg-white flex flex-col items-center rounded-lg p-10 md:p-20">
            <button
                type="button"
                className="absolute right-2 top-2 h-8 w-8 cursor-pointer rounded-full border-none bg-transparent"
                onClick={handleTermsPopup}
            >
                ✕
            </button>
            <h2 className="text-lg font-bold md:text-2xl pb-8">
                Términos y Condiciones
            </h2>
            <div className="overflow-auto flex flex-col p-5">
                {termsAndConditions}
            </div>
        </div>
    )
}

export default TermsPopUp

/* eslint-disable no-console */
import React, { useEffect, useState } from 'react'
import { fetchTermsAndConditions } from '../../api/FetchTermsAndConditions'

type TermsPopUpProps = {
    handleTermsPopup: () => void
}

type TTerms = {
    content: string
}

const TermsPopUp: React.FC<TermsPopUpProps> = ({ handleTermsPopup }) => {
    const [termsAndConditions, setTermsAndConditions] = useState<TTerms | null>(
        null,
    )
    const [loading, setLoading] = useState<boolean>(true)

    useEffect(() => {
        const fetchTermsAndCo = async () => {
            try {
                const data = await fetchTermsAndConditions()
                setTermsAndConditions(data)
            } catch (error) {
                throw new Error('Error fetching Terms and Conditions')
            } finally {
                setLoading(false)
            }
        }
        fetchTermsAndCo()
    }, [])

    return (
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full z-10 bg-white flex flex-col items-center rounded-lg p-10 md:p-20">
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
            <div className="overflow-auto flex flex-col p-5 bg-gray-100 rounded-lg">
                {loading ? 'Loading...' : termsAndConditions?.content}
            </div>
        </div>
    )
}

export default TermsPopUp

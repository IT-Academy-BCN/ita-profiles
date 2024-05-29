import { useState } from 'react'
import { TAbout } from '../../../interfaces/interfaces'

const EditProfileModal = ({ studentData }: { studentData: TAbout }) => {
    const [formData, setFormData] = useState<TAbout | null>(studentData)

    const handleInputChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        if (formData) {
            if (e.target.id === 'githubUrl') {
                setFormData({
                    ...formData,
                    social_media: {
                        ...formData.social_media,
                        github: {
                            url: e.target.value,
                        },
                        linkedin: {
                            // Don't change LinkedIn URL here
                            ...formData.social_media.linkedin,
                        },
                    },
                })
            } else if (e.target.id === 'linkedinUrl') {
                // Handle LinkedIn input
                setFormData({
                    ...formData,
                    social_media: {
                        ...formData.social_media,
                        linkedin: {
                            url: e.target.value,
                        },
                        github: {
                            // Don't change GitHub URL here
                            ...formData.social_media.github,
                        },
                    },
                })
            } else {
                setFormData({ ...formData, [e.target.id]: e.target.value })
            }
        }
    }

    return (
        <div
            data-testid="EditProfileModal"
            className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div className="w-120 relative flex flex-col items-center rounded-lg bg-white py-8 ps-10 px-5">
                <h2 className="text-lg self-start font-bold md:text-2xl">
                    Editar Datos
                </h2>
                <form className="flex flex-col space-y-4 w-72">
                    <div className="overflow-y-auto h-96 grid grid-cols-1 pe-5">
                        <div data-testid="profile-fullname">
                            <p>Nombre y apellidos</p>
                            <input
                                type="text"
                                id="fullname"
                                value=""
                                onChange={}
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>
                        <div data-testid="profile-subtitle">
                            <p>Titular</p>
                            <input
                                type="text"
                                id="subtitle"
                                value=""
                                onChange={}
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>
                        <hr className="h-px my-3 bg-gray-200 border-1" />
                        <div data-testid="profile-github">
                            <p>Link perfil de Github</p>
                            <input
                                type="text"
                                id="githubUrl"
                                value=""
                                onChange={}
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>
                        <div data-testid="profile-linkedin">
                            <p>Link perfil de Linkedin</p>
                            <input
                                type="text"
                                id="linkendinUrl"
                                value=""
                                onChange={}
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>
                        <hr className="h-px my-3 bg-gray-200 border-1" />
                        <div data-testid="profile-description">
                            <p>Descripción</p>
                            <input
                                type="text"
                                id="description"
                                value=""
                                onChange={}
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>
                    </div>
                    <div className="flex items-center justify-center gap-2 me-3 pt-5">
                        <button
                            type="button"
                            className="w-102 h-14 cursor-pointer rounded-lg border border-gray-500 bg-white text-gray-500 text-sm font-semibold  w-60"
                            onClick={}
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            className="w-102 h-14 cursor-pointer rounded-lg border-none bg-primary text-white text-sm font-semibold w-60"
                            onClick={}
                        >
                            Aceptar
                        </button>
                    </div>
                </form>
            </div>{' '}
        </div>
    )
}

export default EditProfileModal

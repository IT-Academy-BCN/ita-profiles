/* eslint-disable no-console */
import React, { useState } from 'react'
import axios from 'axios'
import { useStudentIdContext } from '../../../context/StudentIdContext'
import { TAbout } from '../../../interfaces/interfaces'

const EditProfileModal = ({ studentData }: { studentData: TAbout }) => {
    const [formData, setFormData] = useState<TAbout | null>(studentData)
    const { studentUUID, closeEditModal } = useStudentIdContext()

    const handleInputChange = (
        e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement>,
    ) => {
        if (formData) {
            if (e.target.id === 'github.url') {
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
            } else if (e.target.id === 'linkedin.url') {
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
    const handleSave = async (e: React.FormEvent) => {
        e.preventDefault()
        const url = `https://itaperfils.eurecatacademy.org/api/v1/students/${studentUUID}` // Assuming studentUUID is accessible

        try {
            await axios.put(url, formData)
            // Handle success logic

            closeEditModal()
        } catch (error) {
            // Handle error logic
            console.error('Error updating profile:', error)
        }
    }

    return (
        <div className="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
            <div className="w-120 relative flex flex-col items-center rounded-lg bg-white py-8 ps-10 px-5">
                <h2 className="text-lg self-start font-bold md:text-2xl">
                    Editar Datos
                </h2>
                <form
                    className="flex flex-col space-y-4 w-72"
                    onSubmit={handleSave}
                >
                    <div className="overflow-y-auto h-96 grid grid-cols-1 pe-5">
                        <div>
                            <p className="text-xs text-gray-500 pb-1 pt-2">
                                Nombre y apellidos
                            </p>
                            <input
                                value={formData?.fullname}
                                onChange={handleInputChange}
                                type="text"
                                id="fullname"
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>

                        <div>
                            {' '}
                            <p className="text-xs text-gray-500 pb-1 pt-3">
                                Titular
                            </p>
                            <input
                                type="text"
                                value={formData?.subtitle}
                                onChange={handleInputChange}
                                id="subtitle"
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm"
                            />
                        </div>

                        <hr className="h-px my-3 bg-gray-200 border-1" />

                        <div>
                            {' '}
                            <p className="text-xs text-gray-500 pb-1">
                                Link perfil de Github
                            </p>
                            <input
                                value={formData?.social_media.github.url}
                                onChange={handleInputChange}
                                type="text"
                                id="github.url"
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm "
                            />
                        </div>

                        <div>
                            {' '}
                            <p className="text-xs text-gray-500 pb-1 pt-3">
                                Link perfil de Linkedin
                            </p>
                            <input
                                value={formData?.social_media.linkedin.url}
                                onChange={handleInputChange}
                                type="text"
                                id="linkedin.url"
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm"
                            />
                        </div>

                        <hr className="h-px my-3 bg-gray-200 border-1" />

                        <div>
                            <p className="text-xs text-gray-500 pb-1">
                                Descripción
                            </p>
                            <textarea
                                value={formData?.about}
                                onChange={handleInputChange}
                                id="about"
                                className="border-gray-500 w-full rounded-lg border p-2 px-4 py-4 font-semibold text-sm"
                            />
                        </div>
                    </div>
                    <div className="flex items-center justify-center gap-2 me-3 pt-5">
                        <button
                            type="button"
                            className="w-102 h-14 cursor-pointer rounded-lg border border-gray-500 bg-white text-gray-500 text-sm font-semibold  w-60"
                            onClick={closeEditModal}
                        >
                            Cancelar
                        </button>
                        <button
                            type="submit"
                            className="w-102 h-14 cursor-pointer rounded-lg border-none bg-primary text-white text-sm font-semibold w-60"
                        >
                            Aceptar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    )
}

export default EditProfileModal

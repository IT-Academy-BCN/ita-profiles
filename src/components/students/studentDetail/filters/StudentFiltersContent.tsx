import axios from 'axios'
import React, { useContext, useEffect, useMemo, useState } from 'react'
import { StudentFiltersContext } from '../../../../context/StudentFiltersContext'

const StudentFiltersProvider: React.FC = () => {
    const [roles, setRoles] = useState<string[]>([])
    const [development, setDevelopment] = useState<string[]>([])

    const context = useContext(StudentFiltersContext)

    if (!context) {
        throw new Error('StudentFiltersContext must be provided')
    }

    const { selectedRoles, addRole, removeRole } = context

    const value = useMemo(
        () => ({
            selectedRoles,
            addRole,
            removeRole,
        }),
        [selectedRoles, addRole, removeRole],
    )

    const urlRoles = '/specialization/list'
    const urlDevelopment = '/development/list'

    const fetchData = async (
        url: string,

        setData: React.Dispatch<React.SetStateAction<string[]>>,
    ) => {
        try {
            const response = await axios.get(url)
            setData(response.data)
        } catch (error) {
            // eslint-disable-next-line no-console
            console.error('Error fetching data:', error)
            // Handle error gracefully, e.g., show a message to the user
        }
    }

    useEffect(() => {
        fetchData(urlRoles, setRoles)
        fetchData(urlDevelopment, setDevelopment)
    }, [urlRoles, urlDevelopment])

    const toggleRole = (role: string) => {
        if (selectedRoles.includes(role)) {
            removeRole(role)
        } else {
            addRole(role)
        }
    }

    return (
        <StudentFiltersContext.Provider value={value}>
            <div
                className="w-40 flex flex-col gap-16 flex:none"
                data-testid="student-filters-content"
            >
                <h3 className="text-2xl font-bold text-black-3">Filtros</h3>
                <div className="flex flex-col gap-8">
                    <div className="flex flex-col gap-2">
                        <h4 className="font-bold">Roles</h4>
                        <div>
                            {roles.map((role) => (
                                <label
                                    key={role}
                                    className="label cursor-pointer justify-start p-1"
                                    htmlFor={`roleInput-${role}`}
                                >
                                    <input
                                        id={`roleInput-${role}`}
                                        type="checkbox"
                                        className="border-gray-500 checkbox-primary checkbox mr-2 rounded-md border-2"
                                        checked={selectedRoles.includes(role)}
                                        onChange={() => toggleRole(role)}
                                        data-testid={`my-checkbox-role-${role}`} // Add data-testid here
                                    />
                                    <span>{role}</span>
                                </label>
                            ))}
                        </div>
                    </div>
                    <div className="flex flex-col gap-2">
                        <h4 className="font-bold">Desarrollo</h4>
                        <div>
                            {development.map((tag) => (
                                <label
                                    key={tag}
                                    className="label cursor-pointer justify-start p-1"
                                    htmlFor={`developmentInput-${tag}`}
                                >
                                    <input
                                        type="checkbox"
                                        id={`developmentInput-${tag}`}
                                        className="border-gray-500 checkbox-primary checkbox mr-2 rounded-md border-2"
                                        data-testid="my-checkbox-tag"
                                    />
                                    <span>{tag}</span>
                                </label>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </StudentFiltersContext.Provider>
    )
}

export default StudentFiltersProvider

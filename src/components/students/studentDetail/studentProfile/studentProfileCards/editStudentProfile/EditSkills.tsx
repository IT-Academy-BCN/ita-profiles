import { useState, useEffect } from 'react'
import axios from 'axios'
import {
    useAppDispatch,
    useAppSelector,
} from '../../../../../../hooks/ReduxHooks'
import { updateTags } from '../../../../../../store/slices/student/detailSlice'
import { TSkills, TTag } from '../../../../../../../types'
import { Close } from '../../../../../../assets/svg'
import Modal from '../../../../../molecules/Modal'

const fetchTags = async (
    setTagList: React.Dispatch<React.SetStateAction<TTag[]>>,
    setCustomError: React.Dispatch<React.SetStateAction<string | null>>,
): Promise<void> => {
    try {
        const response = await axios.get<{ tags: TTag[] }>(
            'http://localhost:8000/api/v1/tags',
        )
        setTagList(response.data.tags)
    } catch (error) {
        setCustomError('Error al cargar las habilidades disponibles.')
    }
}

const saveSkillsToAPI = async (
    updatedSkills: string[],
    studentId: string,
    tagList: TTag[],
): Promise<void> => {
    const tagNames = tagList.map((tag) => tag.name.toLowerCase())
    const validSkills = updatedSkills.filter((skill) =>
        tagNames.includes(skill.toLowerCase()),
    )
    const ids = tagList
        .filter((tag) => validSkills.includes(tag.name))
        .map((tag) => tag.id)

    if (!ids.length) {
        throw new Error('No se encontraron habilidades coincidentes.')
    }

    await axios.put(
        `http://localhost:8000/api/v1/student/${studentId}/resume/profile`,
        { tags_ids: ids },
        { headers: { 'Content-Type': 'application/json' } },
    )
}

const EditSkills: React.FC<TSkills> = ({ initialSkills, onClose, onSave, isOpen }) => {
    const [skills, setSkills] = useState<string[]>(initialSkills || [])
    const [newSkill, setNewSkill] = useState<string>('')
    const dispatch = useAppDispatch()
    const [loading, setLoading] = useState<boolean>(false)
    const [customError, setCustomError] = useState<string | null>(null)
    const [tagList, setTagList] = useState<TTag[]>([])
    const { studentDetails } = useAppSelector(
        (state) => state.ShowStudentReducer,
    )
    const studentId = studentDetails.aboutData?.id?.toString() || ''

    useEffect(() => {
        fetchTags(setTagList, setCustomError)
    }, [])

    const capitalizeFirstLetter = (str: string): string =>
        str ? str.charAt(0).toUpperCase() + str.slice(1).toLowerCase() : ''

    const handleAdd = (): void => {
        const formattedSkill = capitalizeFirstLetter(newSkill.trim())
        if (formattedSkill && !skills.includes(formattedSkill)) {
            setSkills([...skills, formattedSkill])
            setNewSkill('')
        } else {
            setCustomError('La habilidad ya ha sido añadida o está vacía.')
        }
    }

    const handleRemoveSkill = (skillToRemove: string): void => {
        setSkills(skills.filter((skill) => skill !== skillToRemove))
    }

    const handleAccept = async (): Promise<void> => {
        if (!studentId) {
            setCustomError(
                'No se pueden guardar las habilidades. No se ha seleccionado ningún estudiante.',
            )
            return
        }

        setLoading(true)
        try {
            await saveSkillsToAPI(skills, studentId, tagList)
            dispatch(
                updateTags(
                    skills.map((skill, index) => ({
                        id: index + 1,
                        name: skill,
                    })),
                ),
            )
            onSave(skills)
            onClose()
        } catch (error) {
            setCustomError(
                'Error al guardar las habilidades. Por favor, inténtalo de nuevo.',
            )
        } finally {
            setLoading(false)
        }
    }

    return (
        <Modal isOpen={isOpen} onClose={onClose}>
            <div className=" flex flex-col h-96 justify-evenly">
                <h1 className="text-2xl font-bold text-[rgba(40,40,40,1)]">
                    Editar skills
                </h1>
                {customError && (
                    <div className="text-red-500">{customError}</div>
                )}
                <div className="flex flex-wrap gap-2">
                    <div className="flex rounded-md bg-gray-5-background h-8 flex-shrink-0">
                        <input
                            type="text"
                            value={newSkill}
                            placeholder="Nuevo skill"
                            onChange={(e) =>
                                setNewSkill(e.target.value)
                            }
                            className="bg-gray-5-background rounded-md text-gray-800 py-1 px-2 text-sm outline-none w-24 placeholder:text-gray-500 focus:placeholder-transparent "
                        />
                        <button
                            className="bg-gray-5-background rounded-md text-gray-800 px-1 text-xl hover:bg-gray-400 outline-none self-center"
                            onClick={handleAdd}
                            disabled={!newSkill.trim()}
                            type="button"
                        >
                            +
                        </button>
                    </div>
                    {skills.map((skill) => {
                        return (
                            <div
                                key={skill}
                                className="flex items-center justify-center rounded-md px-2 py-1 text-sm bg-gray-5-background"
                            >
                                <span className="flex items-center text-gray-800">
                                    {skill}
                                </span>
                                <button
                                    className="cursor-pointer px-2"
                                    onClick={() =>
                                        handleRemoveSkill(skill)
                                    }
                                    type="button"
                                >
                                    <img
                                        src={Close}
                                        alt="close icon"
                                        className="h-3"
                                    />
                                </button>
                            </div>
                        )
                    })}
                </div>

            </div>
            <div className="flex justify-center gap-4 px-6  bottom-12 w-full left-0">
                <button
                    onClick={onClose}
                    className="flex-1 h-[63px] rounded-xl font-bold border border-[rgba(128,128,128,1)] hover:bg-gray-100 text-[rgba(128, 128, 128, 1)];"
                    type="button"
                >
                    Cancelar
                </button>
                <button
                    onClick={handleAccept}
                    className={`flex-1 h-[63px] rounded-xl bg-primary font-bold text-white border mr-4 border-[rgba(128,128,128,1)] ${loading
                        ? 'bg-gray-400 cursor-not-allowed'
                        : 'bg-[#B91879] hover:bg-[#8b125b]'
                        }`}
                    disabled={loading}
                    type="button"
                >
                    {loading ? 'Guardando...' : 'Aceptar'}
                </button>
            </div>
        </Modal >
    )
}

export default EditSkills

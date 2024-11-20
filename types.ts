import { ReactNode } from 'react'

export type TLoginForm = {
    dni: string
    password: string
}

// This could be used globally if we're passing just the children props.
// Good for providers
export type TChildrenProps = {
    children: ReactNode
}

// === UserResponseData ===
export type TUserResponseData = {
    userID: string
    token: string
    studentID: string
}

// === SmallScreenContext ===
export type TSmallScreenContext = {
    isMobile: boolean
    setIsMobile: React.Dispatch<React.SetStateAction<boolean>>
}

// === studentList ===
export type TStudentList = {
    id: string
    fullname: string
    subtitle: string
    photo: string
    tags: TTag[]
}

export type TTag = {
    id: number
    name: string
}

export type TBootcamp = {
    id: string
    name: string
    bootcamp_end_date: string
}

export type TModality = {
    modality: string[]
}

export type TProject = {
    id: number
    name: string
    company_name: string
    tags: TTag[]
    project_url: string
    github_url: string
}
export type TAvailableLanguage = {
    name: string,
    es_name: string
}
export type TLanguageLevel = "Bàsic" | "Intermedi" | "Avançat" | "Natiu";

export type TUpdateStudentLanguageNotification = {
    message: string | null,
}
export type TInitialStateLanguageSlice = {
    isLoadingLanguages: boolean,
    isErrorLanguages: boolean,
    languagesData: TLanguage[],
    isOpenEditAdditionalInformation: boolean,
    isLoadingUpdateLanguages: boolean,
    isErrorUpdateLanguages: boolean,
    notification: TUpdateStudentLanguageNotification
}
export type TLanguage = {
    id: string
    name: string
    level: string
}

export type TAbout = {
    id: number
    name: string
    surname: string
    name: string
    surname: string
    resume: {
        subtitle: string
        social_media: {
            github: string
            linkedin: string
        }
        about: string
    }
    photo: string
    tags: TTag[]
}
export type TStudentFormData = {
    name: string
    surname: string
    subtitle: string
    github_url: string
    linkedin_url: string
    about: string
    tags_ids: number[]
}

export type TAdditionalTraining = {
    id: string
    course_name: string
    study_center: string
    course_beginning_year: number
    course_ending_year: number
    duration_hrs: number
}

export type TCollaboration = {
    uuid: string
    name: string
    collaboration_description: string
    quantity: number
}
export interface TSkills {
    initialSkills: string[]
    onClose: () => void
    onSave: (skills: string[]) => void
}

export type TDragAndDropLanguagesProps = {
    dropLanguages: TLanguage[],
}

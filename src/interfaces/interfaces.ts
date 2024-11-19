import { ReactNode } from 'react'

export interface ILoginForm {
    dni: string
    password: string
}

export interface User {
    id: string
    authToken?: string
}

// This could be used globally if we're passing just the children props.
// Good for providers
export type TchildrenProps = {
    children: ReactNode
}

// === UserResponseData ===
export type UserResponseData = {
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
export interface IStudentList {
    id: string
    fullname: string
    subtitle: string
    photo: string
    tags: ITag[]
}

export interface ITag {
    id: number
    name: string
}

export type TBootcamp = {
    bootcamp_id: string
    name: string
    bootcamp_end_date: string
}

export type TModality = {
    modality: string[]
}

export type TProject = {
    uuid: number
    name: string
    company_name: string
    tags: ITag[]
    project_url: string
    github_url: string
}
export type TAvailableLanguage = {
    name: string,
    es_name: string
}
export type TLanguageLevel = "Bàsic" | "Intermedi" | "Avançat" | "Natiu";

export type TLanguage = {
    id: string
    name: string
    level: string
}

export type TAbout = {
    id: number
    fullname: string
    resume: {
        subtitle: string
        social_media: {
            github: string
            linkedin: string
        }
        about: string
    }
    photo: string
    tags: ITag[]
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

export type UpdateLanguageNotification = {
    message: string | null;
}

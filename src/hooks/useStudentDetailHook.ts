import { useContext, useEffect } from "react";
import { TSmallScreenContext } from "../interfaces/interfaces";
import { useAppDispatch } from "./ReduxHooks";
import { SmallScreenContext } from "../context/SmallScreenContext";
import { useStudentIdContext } from "../context/StudentIdContext";
import getStudentBootcampThunk from "../store/reducers/getStudentBootcamp/studentBootcampThunk";
import getStudentDetailThunk from "../store/reducers/getStudentDetail/studentDetailThunk";
import getStudentProjectsThunk from "../store/reducers/getStudentProjects/studentProjectsThunk";
import getStudentCollaborationThunk from "../store/reducers/getStudentCollaborations/studentCollaborationsThunk";
import getStudentLanguagesThunk from "../store/reducers/getStudentLanguages/studentLanguagesThunk";


const useStudentDetailHook = (role?: string | null) => {
    const { isMobile }: TSmallScreenContext = useContext(SmallScreenContext)
    const { studentUUID } = useStudentIdContext()
    const studentID = localStorage.getItem("studentID")
    const dispatch = useAppDispatch();

    useEffect(() => {
        if (typeof role === "string" && role === "user") {
            dispatch(getStudentDetailThunk(studentID))
            dispatch(getStudentProjectsThunk(studentID))
            dispatch(getStudentCollaborationThunk(studentID))
            dispatch(getStudentBootcampThunk(studentID))
            dispatch(getStudentLanguagesThunk(studentID))
        } else if (!role && studentUUID) {
            dispatch(getStudentDetailThunk(studentUUID))
            dispatch(getStudentProjectsThunk(studentUUID))
            dispatch(getStudentCollaborationThunk(studentUUID))
            dispatch(getStudentBootcampThunk(studentUUID))
            dispatch(getStudentLanguagesThunk(studentUUID))
        }

    }, [dispatch, role, studentID, studentUUID])

    return { isMobile }
}

export {
    useStudentDetailHook,
}

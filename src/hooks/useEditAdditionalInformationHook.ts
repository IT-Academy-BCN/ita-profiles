import { useEffect, useRef, KeyboardEvent } from "react";
import { toggleEditAdditionalInformation } from "../store/slices/student/languagesSlice";
import { useAppDispatch } from "./ReduxHooks";

const useEditAdditionalInformationHook = () => {
  const dispatch = useAppDispatch();
  const refBtnModal = useRef<HTMLButtonElement>(null);

  const handleFocusOnMouseEnter = () => {
    if (refBtnModal.current) {
      refBtnModal.current.focus();
    }
  };

  const handleCloseModalKeyDown = (e: KeyboardEvent<HTMLButtonElement>) => {
    if (e.code === "Escape") {
      dispatch(toggleEditAdditionalInformation());
    }
  };

  const handleCloseModal = () => {
    dispatch(toggleEditAdditionalInformation());
  }

  useEffect(() => {
    if (refBtnModal.current) {
      refBtnModal.current.focus();
    }
  }, []);

  return { refBtnModal, handleFocusOnMouseEnter, handleCloseModalKeyDown, handleCloseModal }
}

export default useEditAdditionalInformationHook;
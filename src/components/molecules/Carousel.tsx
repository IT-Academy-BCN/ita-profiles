import { useRef } from "react";

export function Carousel() {
  const carouselRef = useRef<HTMLDivElement>(null);
  const scrollLeft = () => {
    if (carouselRef.current) {
      const cardWidth = (carouselRef.current?.firstChild as HTMLElement)
        ?.offsetWidth;
      const scrollAmount = carouselRef.current.scrollLeft - cardWidth;
      carouselRef.current.scrollLeft = scrollAmount;
    }
  };

  const scrollRight = () => {
    if (carouselRef.current) {
      const cardWidth = (carouselRef.current?.firstChild as HTMLElement)
        ?.offsetWidth;
      const scrollAmount = carouselRef.current.scrollLeft + cardWidth;
      carouselRef.current.scrollLeft = scrollAmount;
    }
  };
  return { scrollLeft, scrollRight, carouselRef };
}

const useFilterBookings = (viewDate, element) => {
  
    const nextDay = new Date(viewDate);
    const chooseDate = new Date(viewDate);
    const startDay = new Date(element.start_date);
    nextDay.setDate(chooseDate.getDate() + 1);
    return (
        startDay.getTime() >= chooseDate.getTime() &&
        startDay.getTime() < nextDay.getTime()
    );
};

export {useFilterBookings};
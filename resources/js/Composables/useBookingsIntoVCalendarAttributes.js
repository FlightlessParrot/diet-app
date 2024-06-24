
export function useBookingsIntoVCalendarAttributes(Bookings)
{
    

    const data = Bookings.map(e=> {
      const mili = Date.parse(e.start_date);
      return({
        key: e.id,
        highlight: 'green',
        dates: mili,
     
        popover: {
          label: new Date(mili).getHours()+':'+new Date(mili).getMinutes(),
        },
      })},)
    return data;
}
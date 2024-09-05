export const useOfferDurationDescription = (offer) => {
    if (offer.duration === 1) {
        return offer.duration + " miesiąc subskrypcji";
    }
    if (offer.duration % 10 < 5) {
        return offer.duration + " miesiące subskrypcji";
    } else {
        return offer.duration + " miesięcy subskrypcji";
    }
};

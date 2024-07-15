export class VotesTally {
    
    constructor(candidates, positions) {
        this.positions = positions
        for(let i = 0; i < positions.length; i++){
           this[positions[i]] = {candidates: []}
        }
        this.mapCandidatesVote(candidates)
    }

    mapCandidatesVote = (data) => {
        data.forEach(candidate => {
            this[candidate.position].candidates.push(candidate)
        })
        this.setCandidatesPercentageVote() 
    } 

    setCandidatesPercentageVote = () => { 
        for(let i = 0; i < this.positions.length; i++){
            const position = this.positions[i]
            const totalVotes = this[position].candidates.reduce((total, candidate) => total + candidate.votes, 0);
            this[position].totalVotes = totalVotes
            this.setPercentageVote(totalVotes, this[position].candidates) 
         } 
    } 

    setPercentageVote = (totalVote, candidates) => {
        for(let i = 0; i < candidates.length; i++){
           const candidate = candidates[i]
           let totalPercentageVotes = Math.round((candidate.votes / totalVote) * 100)
           if (isNaN(totalPercentageVotes)) {
              totalPercentageVotes = 0
           }
           candidate.votePercentage = totalPercentageVotes
        } 
    }

    getCandidates(){
        let candidates = {}

        for(let i = 0; i < this.positions.length; i++){
            const position = this.positions[i]
            candidates[position] = this[position]
        }

        return candidates;
    }

} 
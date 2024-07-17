export class VotesTally {
    
    constructor(candidates, positions) {
        this.positions = positions
        for(let i = 0; i < positions.length; i++){
           this[positions[i]] = {candidates: []}
        }
        this.#mapCandidatesVote(candidates)
    }

    #mapCandidatesVote = (data) => {
        data.forEach(candidate => {
            this[candidate.position].candidates.push(candidate)
        })
        this.#setCandidatesPercentageVote() 
    } 

    #setCandidatesPercentageVote = () => { 
        for(let i = 0; i < this.positions.length; i++){
            const position = this.positions[i]
            const totalVotes = this[position].candidates.reduce((total, candidate) => total + candidate.votes, 0);
            this[position].totalVotes = totalVotes
            this.#setPercentageVote(totalVotes, this[position].candidates) 
         } 
    } 

    #setPercentageVote = (totalVote, candidates) => {
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

    getElectionCandidatesWinner = () => {
        const candidates = this.getCandidates()

        for (const position in candidates) { 
            if (candidates[position].candidates.length > 1) {
               const winner = {
                  id: 0,
                  votes: 0,
               } 
               candidates[position].candidates.forEach(candidate => {
                  if (candidate.votes > winner.votes) {
                     winner.id = candidate.id
                     winner.votes = candidate.votes
                  }
               })
               if (winner.id == 0) {
                 winner.id = candidates[position].candidates[0].id
               }
               candidates[position].candidates.forEach(candidate => {
                  if (candidate.id === winner.id) {
                    candidates[position] = candidate  
                  }
               })
            }else{
                candidates[position] = candidates[position].candidates[0]
            }
        }
    
        return candidates;
    }

} 